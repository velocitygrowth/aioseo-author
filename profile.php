<?php
/**
 * This file adds the SEO Person Schema field to the user profile page.
 */

namespace JSON_LD_Author_Plugin;

const AUTHOR_PERSON_SCHEMA_KEY = 'person_schema';

\add_action( 'show_user_profile', 'JSON_LD_Author_Plugin\display_user_profile' );
\add_action( 'edit_user_profile', 'JSON_LD_Author_Plugin\display_user_profile' );
function display_user_profile( $user ) {
  $schema = \get_user_meta( $user->ID, 'person_schema', true );
  $schema = empty( $schema ) ? '{}' : $schema;

  ?>
    <h2>SEO Person Schema</h2>
    <p>Enter a JSON-LD schema for this user to be merged into any Person schema for this user.</p>
    <div class="form-wrap">
      <div class="form-field">
        <label for="<?php echo AUTHOR_PERSON_SCHEMA_KEY; ?>">Person Schema</label>
        <textarea name="<?php echo AUTHOR_PERSON_SCHEMA_KEY; ?>" id="<?php echo AUTHOR_PERSON_SCHEMA_KEY; ?>" rows="5" cols="30"><?php echo \esc_textarea( $schema ) ?></textarea>
      </div>
    </div>
  <?php
}

\add_action( 'personal_options_update', 'JSON_LD_Author_Plugin\save_profile_fields' );
\add_action( 'edit_user_profile_update', 'JSON_LD_Author_Plugin\save_profile_fields' );
function save_profile_fields( $user_id ) {
	
	if( ! isset( $_POST[ '_wpnonce' ] ) || ! \wp_verify_nonce( $_POST[ '_wpnonce' ], 'update-user_' . $user_id ) ) {
		return;
	}
	
	if( ! \current_user_can( 'edit_user', $user_id ) ) {
		return;
	}
 
	\update_user_meta( $user_id, AUTHOR_PERSON_SCHEMA_KEY, $_POST[ AUTHOR_PERSON_SCHEMA_KEY ] );
}

// ====== Enable CodeMirror for the textarea ======

\add_action('admin_enqueue_scripts', 'JSON_LD_Author_Plugin\admin_enqueue_scripts');
function admin_enqueue_scripts($hook) {
  
  if ($hook != 'profile.php' && $hook != 'user-edit.php') {
    return;
  }

  $code_mirror_settings = \wp_enqueue_code_editor(array('type' => 'application/json'));
  \wp_localize_script('jquery', 'code_mirror_settings', $code_mirror_settings);
  \wp_enqueue_script('wp-theme-plugin-editor');
  \wp_enqueue_style('wp-codemirror');
}

\add_action('admin_print_footer_scripts', 'JSON_LD_Author_Plugin\admin_print_footer_scripts', 0, 999);
function admin_print_footer_scripts() {
  ?>
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const personSchemaEl = document.getElementById('<?php echo AUTHOR_PERSON_SCHEMA_KEY; ?>');
      if ( personSchemaEl && wp.codeEditor ) {
        wp.codeEditor.initialize(personSchemaEl, code_mirror_settings);
      }
    });
  </script>
  <?php
}