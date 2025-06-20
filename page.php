<?php
  get_header(); 
    while(have_posts()){
      the_post();
     /* pageBanner(array(
        'title' => 'Hello title',
        'subtitle' => 'ho, this is subt',
        'photo' =>'https://cdn.pixabay.com/photo/2017/08/30/01/05/milky-way-2695569__480.jpg'
      ));*/
      pageBanner();
      ?>
     

    <div class="container container--narrow page-section">
    <?php 
    //* child pages*/
      $theParent=wp_get_post_parent_id(get_the_ID());
      if($theParent){?>
         <div class="metabox metabox--position-up metabox--with-home-link">
        <p>
          <a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent);?>"><i class="fa fa-home" aria-hidden="true"></i>Back to <?php echo get_the_title($theParent);?> </a> <span class="metabox__main"><?php the_title();?> </span>
        </p>
      </div>
      <?php
      }
    ?>
      
     
      <?php 
      $testArray=get_pages(array(
        'child_of' => get_the_ID()
      ));
      if($theParent or $testArray ){ ?>
      
      <div class="page-links">
        <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent); ?>"><?php echo get_the_title($theParent);?></a></h2>
        <ul class="min-list">
        <?php
        if($theParent){
          $findChildrenOf = $theParent;
        } else{
          $findChildrenOf = get_the_ID();
        }

        wp_list_pages(array(
        'title_li' => NULL,
        'child_of' => $findChildrenOf,
        'sort_column'=>'menu_order'
      ));
       ?>
        </ul>
      </div>
      <?php }?>
    
      <div class="generic-content">
       <?php the_content();?>
      </div>
    </div>

    <div class="page-section page-section--beige">
      <div class="container container--narrow generic-content">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia voluptates vero vel temporibus aliquid possimus, facere accusamus modi. Fugit saepe et autem, laboriosam earum reprehenderit illum odit nobis, consectetur dicta. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos molestiae, tempora alias atque vero officiis sit commodi ipsa vitae impedit odio repellendus doloremque quibusdam quo, ea veniam, ad quod sed.</p>

        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia voluptates vero vel temporibus aliquid possimus, facere accusamus modi. Fugit saepe et autem, laboriosam earum reprehenderit illum odit nobis, consectetur dicta. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos molestiae, tempora alias atque vero officiis sit commodi ipsa vitae impedit odio repellendus doloremque quibusdam quo, ea veniam, ad quod sed.</p>
      </div>
    </div>

    <?php 
    }
    get_footer();
    ?>