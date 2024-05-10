<?php

function agregar_campos_personalizados_animales() {
    remove_meta_box( 'postcustom', 'animals', 'normal' );
    add_meta_box(
        'imagen_animal',
        'Imagen del animal',
        'mostrar_imagen',
        'Animals', // Aquí se especifica el nombre del tipo de entrada personalizado
        'normal',
        'default'
    );
    add_meta_box(
        'nombre_animal',
        'Nombre de la especie',
        'mostrar_especie',
        'Animals', // Aquí se especifica el nombre del tipo de entrada personalizado
        'normal',
        'default'
    );
    add_meta_box(
        'descripcion_animal',
        'Descripcion',
        'mostrar_descripcion',
        'Animals', // Aquí se especifica el nombre del tipo de entrada personalizado
        'normal',
        'default'
    );
    
}

// Función para mostrar el campo de imagen del animal
function mostrar_imagen($post) {
    $imagen_id = get_post_meta($post->ID, 'imagen_animal', true);
    $imagen_url = wp_get_attachment_image_url($imagen_id, 'thumbnail');
    ?>
    <p>
        <label for="imagen_animal"><?php _e('Imagen del animal:', 'textdomain'); ?></label>
        <br />
        <input type="hidden" name="imagen_animal" id="imagen_animal_input" value="<?php echo esc_attr($imagen_id); ?>" />
        <img id="image_src" src="<?php echo esc_attr($imagen_url); ?>" style="max-width: 100%;" />
        <br />
        <button class="button button-primary" id="upload_imagen"><?php _e('Seleccionar imagen', 'textdomain'); ?></button>
        <button class="button" id="remove_imagen"><?php _e('Eliminar imagen', 'textdomain'); ?></button>
    </p>

    <script>
    jQuery(document).ready(function($){
        $('#upload_imagen').on('click', function(e){
            e.preventDefault();
            var imagen = wp.media({
                title: '<?php _e("Seleccionar o subir imagen", "textdomain"); ?>',
                library: { type: 'image' },
                multiple: false,
                button: { text: '<?php _e("Usar imagen", "textdomain"); ?>' }
            }).open()
            .on('select', function(){
                var attachment = imagen.state().get('selection').first().toJSON();
                $('#imagen_animal_input').val(attachment.id);
                console.log($('#imagen_animal'));
                $('#image_src').attr('src', attachment.url);
                console.log(attachment.id);
            });
        });

        $('#remove_imagen').on('click', function(e){
            e.preventDefault();
            $('#imagen_animal_input').val('');
            $('#image_src').attr('src', '');
        });
    });
    </script>
    <?php
}

// Función para mostrar el campo de nombre de especie del animal
function mostrar_especie($post) {
    $especie = get_post_meta($post->ID, 'nombre_animal', true);
    ?>
    <p>
        <label for="nombre_animal"><?php _e('Nombre de la especie:', 'textdomain'); ?></label>
        <br />
        <input type="text" name="nombre_animal" id="nombre_animal" value="<?php echo esc_attr($especie); ?>" />
    </p>
    <?php
}

// Función para mostrar el campo de descripción del animal
function mostrar_descripcion($post) {
    $descripcion = get_post_meta($post->ID, 'descripcion_animal', true);
    ?>
    <p>
        <label for="descripcion_animal"><?php _e('Descripción:', 'textdomain'); ?></label>
        <br />
        <textarea name="descripcion_animal" id="descripcion_animal" rows="5"><?php echo esc_textarea($descripcion); ?></textarea>
    </p>
    <?php
}

// Acción para guardar los datos de los campos personalizados al guardar la entrada
add_action('save_post', 'guardar_campos_personalizados_animales');

// Función para guardar los datos de los campos personalizados
function guardar_campos_personalizados_animales($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (!current_user_can('edit_post', $post_id)) return;
    
    if (isset($_POST['imagen_animal'])) {
        echo $_POST['imagen_animal'];
        update_post_meta($post_id, 'imagen_animal', sanitize_text_field($_POST['imagen_animal']));
    }

    if (isset($_POST['nombre_animal'])) {
        update_post_meta($post_id, 'nombre_animal', sanitize_text_field($_POST['nombre_animal']));
    }

    if (isset($_POST['descripcion_animal'])) {
        update_post_meta($post_id, 'descripcion_animal', sanitize_textarea_field($_POST['descripcion_animal']));
    }
}