<?php
get_header();
pageBanner(array(
  'title'=> 'All Events',
  'subtitle'=>'See what is coming ...'

));
?>
 

  <div class="container container--narrow page-section">
  <?php
    while(have_posts()){
      the_post();
      get_template_part('template-parts/content-event');
    }
    echo paginate_links();
    ?>
    <hr class="section-break">
    <p>Looking for a recap of past events?<a href="<?php echo site_url('/past-events')?>">Check here </a><div class="a">.</p>
  </div>


  </div>
<?php
get_footer();
?>
