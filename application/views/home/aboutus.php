<!-- Container -->
<div class="main-container">  
    <div class="status-bar">
        <div class="status-bar1 text-center">
            <div class="container"> <div class="tg-sectiontitle white">
                    <h2><?php echo $pagedata->page_title; ?></h2>
                    <h3 class="white upercase">OUR MISSION</h3>
                </div>

            </div>
        </div>
    </div>
    <div class="contact">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="<?php echo SITE_URL; ?>">Home</a> </li>
                <li class="active"><?php echo $pagedata->page_title; ?></li>
            </ul>
            <div class="tg-sectionhead">
                <div class="page-header"><h1 class="title"><span><?php echo $pagedata->page_title; ?></span></h1></div>
                <?php echo html_entity_decode($pagedata->page_content); ?>
            </div>
        </div>
    </div>
</div>