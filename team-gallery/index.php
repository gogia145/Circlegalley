<?php
/*
   Plugin Name: Team Gallery
   Version: 1.0
   Author: Vikas Gautam
*/


function myteam_post() {
    $args = array(
      'public' => true,
      'label'  => 'My Team',
	  'supports' => array( 'title','thumbnail','custom-fields')
    );
    register_post_type( 'myteam', $args);
}
add_action( 'init', 'myteam_post' );


add_action( 'wp_insert_post', 'wpse128767_add_meta' );
function wpse128767_add_meta( $post_id ) {
	
	$designation = get_post_meta( $post_id, 'designation', true );
	$our_views = get_post_meta( $post_id, 'our_views', true );
	if($designation=="")
	{
        $designation="Manager";
        update_post_meta( $post_id, 'designation', $designation );
	}
	else 
	{
		update_post_meta( $post_id, 'designation', $designation );
	}
	
	
	if($our_views=="")
	{
        $our_views="Owsesome  Working Enviournment";
        update_post_meta( $post_id, 'our_views', $our_views );
	}
	else 
	{
		update_post_meta( $post_id, 'our_views', $our_views );
	}
	
	
}

	

function myteam_stylesheet() 
	{
		wp_enqueue_style( 'myCSS', plugins_url('slide_effect.css', __FILE__ ) );
		wp_enqueue_style( 'myCSS2', plugins_url('team_photos_slide_effect.css', __FILE__ ) );
	}
add_action('admin_print_styles', 'myteam_stylesheet');


	
function  team_list()
{
	myteam_stylesheet();

		
	?>
	
	<div id='round-photo'>
    	<!--Image1-->
	<?php 
	 global $post;
	query_posts("post_type=myteam&showposts=-1"); 
		     while(have_posts()):  the_post();
			 
			 $teamimage = get_the_post_thumbnail_url(get_the_ID(),'full');
			 
			 //echo "<pre>";
			 //print_r($post);
			 //echo $post->ID;
		?>
		
       
        <div class='rp-item'>
            <div class='info-item round slide_effect to-top-left-corner'>
                <a  id="clickbutton<?php echo $post->ID; ?>" ref="" target='' rel=''>
                    <div class='img'>
                        <img src='<?php echo $teamimage; ?>' />
                    </div>
                    <div class='info'>
                        <h3><?php the_title(); ?></h3>
                        <p><?php echo get_post_meta($post->ID, 'designation', true );  ?></p>
                    </div>
                </a>
            </div>
        </div>
        <!-- The Modal -->
 
            <div id="modelpopup<?php echo $post->ID; ?>" class="modal">
                <!-- Modal content -->
                <div class="modal-content">
                    <span class="close close<?php echo $post->ID; ?>">&times;</span>
					   <h3 align="center">What Our Employees say about us!</h3>
                        <h4 align="center"><?php echo get_post_meta($post->ID, 'our_views', true );  ?></h4>
                </div>
            </div>
        
		
		<script>
	// Get the modal
	var modal = document.getElementById('modelpopup<?php echo $post->ID; ?>');
	
	// Get the button that opens the modal
	var btn = document.getElementById("clickbutton<?php echo $post->ID; ?>");
	
	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close<?php echo $post->ID; ?>")[0];
	
	// When the user clicks the button, open the modal 
	btn.onclick = function() {
		modal.style.display = "block";
	}
	
	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
		modal.style.display = "none";
	}
	
	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}
	</script>
	
		<?php endwhile; wp_reset_query(); ?>
		
	
	  </div>
	 
	
	 
	
	<?php 
	
}	

add_shortcode("team_list","team_list");

?>