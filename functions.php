<?php
require get_theme_file_path('/inc/search-route.php');

function alexnaranjo_custom_rest(){
  register_rest_field('post','authorName',array(
    'get_callback' => function(){return get_the_author();}
  ));
}
add_action('rest_api_init','alexnaranjo_custom_rest');

function pageBanner($args = NULL){
  if(!$args['title']){
    $args['title'] = get_the_title();    
  }
  if(!$args['subtitle']){
    $args['subtitle'] = get_field('page_banner_subtitle');    
  }
  if(!$args['photo']){
    if (get_field('page_banner_background_image') AND !is_archive() AND !is_home() ) {
      $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
    } else {
      $args['photo']=get_theme_file_uri('/images/ocean.jpg');
    }
  }
  ?>
  <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo'];?>);"></div>
        <div class="page-banner__content container container--narrow">
          <h1 class="page-banner__title"><?php echo $args['title']?></h1>
          <div class="page-banner__intro">
          <p><?php echo $args['subtitle']; ?></p>
          </div>
        </div>
     </div>

  <?php
}

function alex_files() {
  /**chage style fr scrip javascript */
  wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=YOUR_API_KEY_HERE', NULL, '1.0', true);
    wp_enqueue_script('main-alex-naranjo-js', get_theme_file_uri('/build/index.js'), array('jquery'),'1.0',true);
    /**Style */
    /**only one style */
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('alex_naranjo_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('alex_naranjo_extra_styles', get_theme_file_uri('/build/index.css'));
    wp_localize_script('main-alex-naranjo-js','alexnaranjoData',array(
      'root_url'=>get_site_url()
    ));
  
}
/**CSS files */
add_action('wp_enqueue_scripts', 'alex_files');

//**Change title in each page */
function alex_features(){
  /* Dynamic Menu
  register_nav_menu('headerMenuLocation', 'Header Menu Location');
  register_nav_menu('footerLocationOne', 'Footer One');
  register_nav_menu('footerLocationTwo', 'Footer Two');
  */
  //*get festures from pages */
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_image_size('professorLandscape',400,260,true);
  add_image_size('professorPortrait',480,650,true);
  add_image_size('pageBanner',1500,350,true);




}
add_action('after_setup_theme','alex_features');

function alex_adjust_queries($query){
  if(!is_admin() AND is_post_type_archive('campus') AND $query->is_main_query()){
    $query->set('posts_per_page',-1);
  }  
  if(!is_admin() AND is_post_type_archive('program') AND $query->is_main_query()){
    $query->set('orderby','title');
    $query->set('order','ASC');
    $query->set('posts_per_page',-1);
  }  

  /*!is_admin is back end*/
  if (!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) {
    $today = date('Ymd');
    /*pagination
    $query->set('posts_per_page', '1');
    */
    $query->set('meta_key', 'event_date');
    $query->set('orderby', 'meta_value_num');
    $query->set('order', 'ASC');
    $query->set('meta_query', array(
              array(
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric'
              )
            ));
  }


}
add_action('pre_get_posts','alex_adjust_queries');
function alexMapKey($api){
  $api['key']='AIzaSyBhWMrhyyxUPCcHhzpTIKh2RR9SdVtXYyU';
  return ($api);

}
add_filter('acf/fields/google_map/api','alexMapKey');


//redirect subscriber accounts out of admin and onto homepage
add_action('admin_init','redirectSubtoFrontend');

function redirectSubtoFrontend (){
  $ourCurrentUser =wp_get_current_user();
  if(count($ourCurrentUser->roles)==1 AND $ourCurrentUser->roles[0]=='subscriber'){
   wp_redirect(site_url('/'));
   exit;
  }  
}


add_action('wp_loaded','noSubsAdminBar');

function noSubsAdminBar(){
  $ourCurrentUser =wp_get_current_user();
  if(count($ourCurrentUser->roles)==1 AND $ourCurrentUser->roles[0]=='subscriber'){
   show_admin_bar(false);
  
  }  
}

/// customize Login Screen
add_filter('login_headerurl','ourHeaderUrl');
function ourHeaderUrl(){
  return esc_url(site_url('/'));

}
add_action('login_enqueue_scripts','ourLoginCSS');
function ourLoginCSS(){
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('alex_naranjo_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('alex_naranjo_extra_styles', get_theme_file_uri('/build/index.css'));
}
add_filter('login_headertitle', 'ourLoginTitle');
function ourLoginTitle(){
  return get_bloginfo('name');
}