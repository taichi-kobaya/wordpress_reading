<?php get_header(); ?>

<div id="content">

<?php do_action( 'xeory_prepend_content' ); ?>

<div class="wrap">

  <?php do_action( 'xeory_prepend_wrap' ); ?>

    <?php bzb_breadcrumb(); ?>

  <div id="main" <?php bzb_layout_main(); ?> role="main">

  <?php do_action( 'xeory_prepend_main' ); ?>

    <div class="main-inner">

    <?php do_action( 'xeory_prepend_main-inner' ); ?>

    <?php
      if ( have_posts() ) :

        while ( have_posts() ) : the_post();

        ?>

    <?php 
    global $post;
    $cf = get_post_meta($post->ID);
    ?>
    <article id="post-<?php the_id(); ?>" <?php post_class(); ?>>

      <header class="post-header">
        <ul class="post-meta list-inline">
          <li class="date updated"><i class="fa fa-clock-o"></i> <?php the_time('Y.m.d');?></li>
        </ul>
        <h1 class="post-title"><?php the_title(); ?></h1>
        <div class="post-header-meta">
          <?php bzb_social_buttons();?>
        </div>
      </header>

      <section class="post-content">

        <?php if( get_the_post_thumbnail() ) : ?>
        <div class="post-thumbnail">
          <?php the_post_thumbnail(); ?>
        </div>
        <?php endif; ?>
        <?php
          the_content(); 

          $args = array(
           'before' => '<div class="pagination">',
           'after' => '</div>',
           'link_before' => '<span>',
           'link_after' => '</span>'
          );

          wp_link_pages($args);
        ?>

      </section>

      <footer class="post-footer">

      <?php bzb_social_buttons();?>

        <ul class="post-footer-list">
          <li class="cat"><i class="fa fa-folder"></i> <?php the_category(', ');?></li>
          <?php 
          $posttags = get_the_tags();
          if($posttags){ ?>
          <li class="tag"><i class="fa fa-tag"></i> <?php the_tags('');?></li>
          <?php } ?>
        </ul>
      </footer>

      <?php echo bzb_get_cta($post->ID); ?>

      <div class="post-share">

      <h4 class="post-share-title">SNSでもご購読できます。</h4>
      <?php if(  is_active_sidebar('under_post_area') ){
        dynamic_sidebar('under_post_area');
      } ?>

    <?php
      $twitter_from_db = "https://twitter.com/" . esc_html(get_option('twitter_id'));
      $feedly_url = "https://feedly.com/i/subscription/feed/" . urlencode(get_bloginfo('rss2_url'));
    ?>

        <aside class="post-sns">
          <ul>
            <li class="post-sns-twitter"><a href="<?php echo $twitter_from_db;?>"><span>Twitter</span>でフォローする</a></li>
            <li class="post-sns-feedly"><a href="<?php echo $feedly_url;?>"><span>Feedly</span>でフォローする</a></li>
          </ul>
        </aside>
      </div>

      <?php bzb_show_avatar();?>

    <?php comments_template( '', true ); ?>

    </article>


    <?php

        endwhile;

      else :
    ?>

    <p>投稿が見つかりません。</p>

    <?php
      endif;
    ?>

    <?php do_action( 'xeory_append_main-inner' ); ?>

    </div><!-- /main-inner -->

    <?php do_action( 'xeory_append_main' ); ?>

  </div><!-- /main -->

<?php get_sidebar(); ?>

    <?php do_action( 'xeory_append_wrap' ); ?>

</div><!-- /wrap -->

<?php do_action( 'xeory_append_content' ); ?>

</div><!-- /content -->

<?php //記事ページのみに構造化データを出力
if ( is_single()): ?>
  <?php
    //サムネイルを取得
    $thumbnail_id = get_post_thumbnail_id($post);
    $imageobject = wp_get_attachment_image_src( $thumbnail_id, 'full' );
    if( !$imageobject ){
      $imageobject[0] = get_template_directory_uri() .'/lib/images/noimage.jpg';
    }
    $logo_image = get_option('logo_image');
    if( !$logo_image ){
      $logo_image = get_template_directory_uri() .'/lib/images/masman.png';
    }
  ?>
  <script type="application/ld+json">
  {
    "@context": "http://schema.org",
    "@type": "BlogPosting",
    "mainEntityOfPage":{
      "@type":"WebPage",
      "@id":"<?php the_permalink(); ?>"
    },
    "headline":"<?php the_title(); ?>",
    "image": [
      "<?php echo $imageobject[0]; ?>"
    ],
    "datePublished": "<?php echo get_date_from_gmt(get_post_time('c', true), 'c');?>",
    "dateModified": "<?php echo get_date_from_gmt(get_post_modified_time('c', true), 'c');?>",
    "author": {
      "@type": "Person",
      "name": "<?php the_author(); ?>"
    },
    "publisher": {
      "@type": "Organization",
      "name": "<?php bloginfo('name'); ?>",
      "logo": {
        "@type": "ImageObject",
        "url": "<?php echo $logo_image; ?>"
      }
    },
    "description": "<?php echo get_the_excerpt(); ?>"
  }
  </script>
<?php endif; ?>


<?php get_footer(); ?>


