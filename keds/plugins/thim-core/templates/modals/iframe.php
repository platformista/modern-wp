<?php
?>
<div class="tc-modal md-modal md-effect-16" id="tc-modal-iframe" data-template="tc-modal-iframe">
</div>
<div class="md-overlay"></div>

<script type="text/html" id="tmpl-tc-modal-iframe">
    <div class="md-content">
        <h3 class="title">{{data.title}}<span class="close"></span></h3>

        <div class="main text-center">
            <iframe src="{{data.src}}" width="100%" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
</script>
