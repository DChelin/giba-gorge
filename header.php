<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>
            <?php 
            if ( is_front_page() ){ echo 'Home'; echo ' | ';  bloginfo( 'name' );}
            else { echo wp_title(''); echo ' | ';  bloginfo( 'name' );}?>
        </title>
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>