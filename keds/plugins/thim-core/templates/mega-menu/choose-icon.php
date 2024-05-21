<?php

?>
<h3 class="title">Choose Icons<span class="close"></span></h3>
<div class="main">
    <div class="top">
        <select name="package" class="package-selector">
            <# _.each(data.packages, function(package) { #>
                <option value="{{package.key}}" {{data.package==package.key ?
                'selected="selected"' : ''}}>{{package.name}} ({{package.fonts.length}})</option>
                <# }) #>
        </select>

        <input type="text" name="search" class="search" placeholder="Search Icons">
    </div>

    <div class="tc-icons">
        <# _.each(data.currentPackage, function(font) {
                var c = data.package + ' ' + font;
                if (font == data.icon) c+= ' active';
                #>
            <span class="tc-icon show {{c}}" data-icon="{{c}}"></span>
            <# }); #>
    </div>
</div>
