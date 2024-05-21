<div class="top">
    <h2>General Setup</h2>

    <div class="caption">
        <p>Let's do some quick set up for your site!</p>
    </div>

    <form>
        <div class="form-group">
            <label for="blogname">What is the name of your website?</label>
            <input id="blogname" name="blogname" type="text" class="regular-text" value="<?php echo esc_html( get_bloginfo( 'name' ) ); ?>">
        </div>

        <div class="form-group">
            <label for="blogdescription">How would you describe your site?</label>
            <input id="blogdescription" name="blogdescription" type="text" class="regular-text" value="<?php echo esc_html( get_bloginfo( 'description' ) ); ?>">
        </div>
    </form>
</div>

<div class="bottom">
    <a class="tc-skip-step">Skip</a>
    <button class="button button-primary tc-button tc-run-step" data-request="yes">Save</button>
</div>
