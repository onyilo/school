<nav class="art-nav">
    <div class="art-nav-inner">
    <ul class="art-hmenu">
            <?php $menu = GenerateMenu(); 
				//echo $menu;
			?>
        </ul> 
   </div>
    </nav>
<div class="art-sheet clearfix">
            <div class="art-layout-wrapper">
                <div class="art-content-layout">
                    <div class="art-content-layout-row"> 
   <div class="art-layout-cell art-sidebar1">
   <!-- <div class="art-block clearfix">
        <div class="art-blockheader">
        <h3 class="t">Block</h3>
        </div>
        
        <div class="art-blockcontent"><p>Enter Block content here...</p>
            <br>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam pharetra, tellus sit amet congue vulputate, nisi erat iaculis nibh, vitae feugiat sapien ante eget mauris.</p>
        </div>
    </div>-->
	
    <div class="art-vmenublock clearfix">
        <div class="art-vmenublockheader">
        <h3 class="t">Menu</h3>
        </div>
        
        <div class="art-vmenublockcontent">
            <ul class="art-vmenu">
                <?php echo $menu;?>
            </ul>
        
        </div>
    </div>
    </div>
            