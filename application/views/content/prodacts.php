<div class="inner-pages"  id="prodacts">

    <section class="headings" style="background: -webkit-linear-gradient(rgba(32, 51, 100, 0.5), rgba(32, 51, 100, 0.5)), url(../public4/images/bg/bg-details.jpeg) no-repeat center center;
         background: linear-gradient(rgba(32, 51, 100, 0.5), rgba(32, 51, 100, 0.5)), url(../public4/images/bg/bg-details.jpeg) no-repeat center center;">
        <div class="text-heading text-center">
            <div class="container">
                <h1>Properties</h1>

            </div>
        </div>
    </section>

    <section class="team">
        <div class="container">
            <div class="row">
                <?php if(isset($prodact)){
                foreach ($prodact as $value){?>
                    <?php  $link = $this->db->query("SELECT url FROM links WHERE page ='prodact' AND  content_id ='$value->id' ")->result_object();
                    if ($link){
                        $link = '/'.$link[0]->url;
                    }else {
                        $link = "javascript:;";
                    }
                    ?>
                    <div class="col-lg-12 agent-mb">
                        <div class="agent agent-row shadow-hover">
                            <a href="<?=$link ?>"style="height: 100%;" class="agent-img  added-effect">
                                <div class="img-fade"></div>
                                <div style="background-color: #ffb200;border-radius: 5px;   font-weight: bold;" class="button alt agent-tag">For Rent</div>
                                <?php if ($value->user_id != 0){?>
                                    <img src="/admin/public1/uploads/php/files/prodact_user/medium/<?= $value->thePhoto?>"style="height: 50vh;" alt="bbb">

                                <?php }else{?>
                                <img src="https://admin.hurenkangoedkoper.com/<?=$value->thePhoto ?>"style="height: 50vh;" alt="ccc" />

                                <?php }?>
                            </a>
                            <div class="agent-content">
                                <div class="agent-details">
                                    <li style="text-align:right ; list-style-type: none;"><?=$value->date ?></li>
                                    <h4><i class="fa fa-tag icon"></i><a href="<?=$link ?>"> <?= $value->theTitle ?></a> </h4>
                                    <!--                                    <p> <i class="fa fa-object-group icon"></i>  <a href="agent-details.html">--><?//= $value->theType ?><!--</a></p>-->




                                </div>


                                <div class="agent-text">
                                </div>
                                <div class="agent-footer center">


                                    <div class="agent-details">

                                        <p style="font-size: 23px;float: right;"><i style=" padding-right: 4px" >€</i><?= $value->thePrice ?></p>

                                        <p style="font-size: 17px"><i class="fa fa-object-group icon"></i><?= $value->theType?></p>
                                        <p><i class="fa fa-bed icon"></i><?= $value->theRoom?></p>
                                        <p><i class="fa fa-map-marker"></i><?= $value->theLocation ?> </p>

                                    </div>
                                    <li style="text-align:right;list-style-type: none;"> <a href="<?=$link ?>" class="btn btn-secondary">Read More...</a></li>




                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                <?php }}else{?>
                            <h1>  not found</h1>
                <?php }?>
            </div>
            <!-- end row -->
            <?php if(sizeof($allProductsNUM) > 0) {
                $urls = "$_SERVER[REQUEST_URI]";
                $query = parse_url($urls, PHP_URL_QUERY);

                if ($query) {
                    $urls .= '&page_no';
                } else {
                    $urls .= '?page_no';
                }
                ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <?php
                        if ($cateNum < 2) {
                            $href = "javascript:;";
                            $href2 = "javascript:;";
                        } else {
                            $href = "$urls=" . $prev;
                            $href2 = "$urls=" . $next;
                        }
                        ?>
                        <li class="page-item <?php if ($pageNum < 2) { ?> disabled <?php } ?>">
                            <a class="page-link page-link-prev" href="<?= $href ?>" aria-label="Previous" tabindex="-1" aria-disabled="true">
                                    <span aria-hidden="true">
                                        <i class="icon-long-arrow-left"></i>
                                    </span> <i class="mdi mdi-arrow-left"></i> Prev
                            </a>
                        </li>
                        <?php
                        for ($i = 0; $i < $cateNum; $i++) {
                            if ($i + 1 == $pageNum) {
                                ?>
                                <li class="page-item active" aria-current="page"><a class="page-link" href="javascript:;"><?= $i + 1 ?></a></li>
                            <?php } else {


                                ?>
                                <li class="page-item" aria-current="page"><a class="page-link" href="<?=$urls?>=<?= $i + 1 ?>"><?= $i + 1 ?></a></li>
                            <?php }
                        }
                        ?>

                        <!--  <li class="page-item-total">of 6</li> -->
                        <li class="page-item
                                        <?php
                        if ($pageNum == $cateNum) {
                            echo "disabled";
                        } else {

                        }
                        ?>">
                            <a class="page-link page-link-next" href="<?= $href2 ?>" aria-label="Next">
                                Next <i class="mdi mdi-arrow-right"></i> <span aria-hidden="true">
                                            <i class="icon-long-arrow-right"></i>
                                    </span>
                            </a>

                        </li>
                    </ul>

                </nav>
            <?php } ?>
        </div>
    </section>












</div>
