
<div class="card card-custom gutter-b example example-compact">
    <div class="card-header">
        <h3 class="card-title"> <a href="https://admin.hurenkangoedkoper.com/" class="btn btn-primary yesbtn" >back</a></h3>
        <div class="card-toolbar">
            <div class="example-tools justify-content-center">
                <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
            </div>
        </div>
    </div>
    <!--begin::Form-->

        <div class="card-body">


<!--            <label for="pet-select">Choose a Category:</label>-->
            <?php
            if (isset($prodact )){
            foreach ($prodact as $value){ ?>

            <h3> title: <br> <?= $value->theTitle ?></h3>
            <p> type:<br> <?= $value->theType ?></p>
            <p> Location:<br> <?= $value->theLocation ?></p>
            <p> Text:<br> <?= $value->theText ?></p>
            <p> phone number:<br> <?= $value->theBath ?></p>
            <p> owner name:<br> <?= $value->theNameHome ?></p>
                <div class="row">
                    <div class="col-lg-3 col-md-12">
                        <?php if (isset($value->parking )){?>
                            <label for="vehicle1"> Parking</label><br>


                        <?php }?>



                    </div>
                    <div class="col-lg-3 col-md-12">
                        <?php if (isset($value->balcony )){?>
                            <label for="vehicle1"> balcony</label><br>


                        <?php }?>



                    </div>
                    <div class="col-lg-3 col-md-12">
                        <?php if (isset($value->pool )){?>
                            <label for="vehicle1"> pool</label><br>


                        <?php }?>


                    </div>
                    <div class="col-lg-3 col-md-12">
                        <?php if (isset($value->cable )){?>
                            <label for="vehicle1"> cable</label><br>


                        <?php }?>



                    </div>
                    <div class="col-lg-3 col-md-12">
                        <?php if (isset($value->garden )){?>
                            <label for="vehicle1"> garden</label><br>


                        <?php }?>


                    </div>
                </div>

            <?php if (isset($value->thePhoto )){?>
                    <img style="width: 150px; height: 200px;"  src="/public1/uploads/php/files/prodact_user/<?= $value->thePhoto?>">



            <?php }?>
                <?php if (isset($value->thePhoto1)){?>
                    <img style="width: 150px; height: 200px;" src="/public1/uploads/php/files/prodact_user1/<?= $value->thePhoto1?>">
<!--                    "http://sub.domain.com/public1/uploads/php/files/prodact_user/--><?//= $value->thePhoto?><!--"-->


                <?php }?>
                <?php if (isset($value->thePhoto2)){?>
                    <img style="width: 150px; height: 200px;" src="/public1/uploads/php/files/prodact_user2/<?= $value->thePhoto2?>">

                <?php }?>
                <?php if (isset($value->thePhoto3)){?>
                    <img style="width: 150px; height: 200px;" src="/public1/uploads/php/files/prodact_user3/<?= $value->thePhoto3?>" alt="bbb">

                <?php }?>
                <?php if (isset($value->thePhoto4)){?>
                    <img style="width: 150px; height: 200px;"  src="/public1/uploads/php/files/prodact_user4/<?= $value->thePhoto4?>">


                <?php }?>

            <?php }}?>

        </div>




    <!--end::Form-->
</div>


</div>



