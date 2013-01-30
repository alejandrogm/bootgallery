<?php
//Activate Thumbnails
if ( function_exists( 'add_theme_support' ) )
add_theme_support( 'post-thumbnails' );

//Register menu function
if ( function_exists( 'add_theme_support' ) )
add_theme_support ('nav-menus');
add_action('init', 'registrar_navegacion' );
function registrar_navegacion() {
    register_nav_menus (array(
        'header'   => __('Menu Header', 'storelicious' ),
    ));
}

function create_menu() {
	$menu_id = 	wp_create_nav_menu('Top Menu');
	$menu = array( 
	    'menu-item-type' => 'custom', 
	    'menu-item-url' => get_home_url('/'),
	    'menu-item-title' => 'Home', 
	    'menu-item-status' => 'publish', 
	    );
	wp_update_nav_menu_item( $menu_id, 0, $menu );
	$locations = get_theme_mod('nav_menu_locations');
	$locations['header'] = $menu_id ;
	set_theme_mod('nav_menu_locations', $locations);
}
if( ! has_nav_menu('header') ){ add_action('init', 'create_menu' ); }

//SEO meta boxes
$key = "SEO";
$meta_boxes = array(
"title" => array(
    "nombre" => "title",
    "titulo" => "Title",
    "descripcion" => "Meta Title (If you don't know about SEO or want to have the same Title in the Meta title leave this empty.)"),
"description" => array(
    "nombre" => "description",
    "titulo" => "Description",
    "descripcion" => "Meta Description (If you don't know about SEO leave this empty, if you don't put something meta description will not exist.)"),
);

function crear_meta_box() {
   global $key;
   if( function_exists( 'add_meta_box' ) ) {
       add_meta_box( 'seo-meta-boxes', ucfirst( $key ) . ' Meta info', 'show_meta_box', 'post', 'normal', 'high' );
   }
}

function show_meta_box() {
	global $post, $meta_boxes, $key;
?>

<div class="form-wrap">
	<?php
	wp_nonce_field( plugin_basename( __FILE__ ), $key . '_wpnonce', false, true );
	foreach($meta_boxes as $meta_box) {
	    $data = get_post_meta($post->ID, $key, true);?>

    <div class="form-field form-required">
        <label for="<?php echo $meta_box[ 'nombre' ]; ?>"><?php echo $meta_box[ 'titulo' ]; ?></label>
        <input type="text" name="<?php echo $meta_box[ 'nombre' ]; ?>" value="<?php echo htmlspecialchars( $data[ $meta_box[ 'nombre' ] ] ); ?>" />
        <p><?php echo $meta_box[ 'descripcion' ]; ?></p>
    </div>

    <?php } // End foreach?>
</div>

<?php
} // End function show_meta_box

function grabar_meta_box( $post_id ) {
    global $post, $meta_boxes, $key;

    foreach( $meta_boxes as $meta_box ) {
        $data[ $meta_box[ 'nombre' ] ] = $_POST[ $meta_box[ 'nombre' ] ];
    }

    if ( !wp_verify_nonce( $_POST[ $key . '_wpnonce' ], plugin_basename(__FILE__) ) )
        return $post_id;

    if ( !current_user_can( 'edit_post', $post_id ))
        return $post_id;

    update_post_meta( $post_id, $key, $data );
}

add_action( 'admin_menu', 'crear_meta_box' );
add_action( 'save_post', 'grabar_meta_box' );

//END SEO meta boxes

function validaMetadata($textoValidar){
    if($textoValidar == "" || !preg_match("/\S/",$textoValidar) || strlen($textoValidar) < 1){
            return false;
    }
    else{
            return true;
    }
}

//Options Panel


$themename = "Boot Gallery";
$shortname = "bg";

$categories = get_categories('hide_empty=0&orderby=name');
$wp_cats = array();
foreach ($categories as $category_list ) {
       $wp_cats[$category_list->cat_ID] = $category_list->cat_name;
}
array_unshift($wp_cats, "Choose a category"); 

$options = array (
 
array( "name" => $themename." Options",
	"type" => "title"),
 

array( "name" => "SEO Tools",
	"type" => "section"),
array( "type" => "open"),
	
array( "name" => "Home Title",
	"desc" => "Enter your Home Meta Title",
	"id" => $shortname."_title",
	"type" => "text",
	"std" => ""),
	
array( "name" => "Home Description",
	"desc" => "Enter your Home Meta Description",
	"id" => $shortname."_description",
	"type" => "text",
	"std" => ""),
	
array( "name" => "Google Analytics Code",
	"desc" => "You can paste your Google Analytics or other tracking code in this box. This will be automatically added to the footer.",
	"id" => $shortname."_ga_code",
	"type" => "textarea",
	"std" => ""),
	
array( "type" => "close"),
 
);


function mytheme_add_admin() {
 	global $themename, $shortname, $options;
	 
	if ( $_GET['page'] == basename(__FILE__) ) {
	
		if ( 'save' == $_REQUEST['action'] ) {
			foreach ($options as $value) {
				update_option( $value['id'], $_REQUEST[ $value['id'] ] );
			}
			foreach ($options as $value) {
				if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); }
				else { delete_option( $value['id'] ); }
			}
			header("Location: admin.php?page=functions.php&saved=true");
			die;
	 
		} 
		
		else if( 'reset' == $_REQUEST['action'] ) {	
			foreach ($options as $value) {
				delete_option( $value['id'] );
			}
			header("Location: admin.php?page=functions.php&reset=true");
		die;
		}
	}
	add_menu_page($themename." Options", $themename." Options", 'administrator', basename(__FILE__), 'mytheme_admin');
}

function mytheme_add_init() {
	$file_dir=get_bloginfo('template_directory');
	wp_enqueue_style("functions", $file_dir."/functions/functions.css", false, "1.0", "all");
}

function mytheme_admin() { 
	global $themename, $shortname, $options;
	$i=0;
	if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
	if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
?>
	<div class="wrap rm_wrap">
		<h2><?php echo $themename; ?> Options</h2>

		<div class="rm_opts">
			<form method="post">
				<?php foreach ($options as $value) {
					switch ( $value['type'] ) {
					case "open":
					break;
					case "close":
				?>
				</div>
				</div>
		 
				<?php break;
				case "title":
				?>
				<p>To easily use the <?php echo $themename;?> theme, you can use the menu below.</p>
				<?php break; 
				case 'text':
				?>
				<div class="rm_input rm_text">
					<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
					<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id'])  ); } else { echo $value['std']; } ?>" />
					<small><?php echo $value['desc']; ?></small>
		 
				</div>
				<?php
				break;
				case 'textarea':
				?>
		
				<div class="rm_input rm_textarea">
					<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
					<textarea name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id']) ); } else { echo $value['std']; } ?></textarea>
					<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
				</div>		  
				<?php
				break;
				case 'select':
				?>
		
				<div class="rm_input rm_select">
					<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
					<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
						<?php foreach ($value['options'] as $option) { ?>
						<option <?php if (get_settings( $value['id'] ) == $option) { echo 'selected="selected"'; } ?>><?php echo $option; ?>
						</option><?php } ?>
					</select>
					<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
				</div>
				<?php
				break;		 
				case "checkbox":
				?>		
				<div class="rm_input rm_checkbox">
					<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
					<?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
					<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
					<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
				</div>
				<?php break; 
				case "section":
				$i++;
				?>		
				<div class="rm_section">
					<div class="rm_title">
						<h3><?php echo $value['name']; ?></h3>
						<span class="submit"><input name="save<?php echo $i; ?>" type="submit" value="Save changes" /></span>
						<div class="clearfix"></div>
					</div>
					<div class="rm_options">
		<?php break;		 
		} //End foreach ($options as $value) 
		} //End switch ( $value['type'] ) {
		?>		 
		<input type="hidden" name="action" value="save" />
		</form>
		
		<form method="post">
			<p class="submit">
				<input name="reset" type="submit" value="Reset" />
				<input type="hidden" name="action" value="reset" />
			</p>
		</form>
	 </div> 
 
<?php
} // End function mytheme_admin

add_action('admin_init', 'mytheme_add_init');
add_action('admin_menu', 'mytheme_add_admin');

?>