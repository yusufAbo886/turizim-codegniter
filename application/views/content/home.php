<style>
    input::-webkit-input-placeholder {
      text-align: center !important;
    }
</style>
<?php foreach ($homeheader as $value){?>
    <div class="back" style="background-image: -webkit-linear-gradient(rgba(32, 51, 100, 0.5), rgba(32, 51, 100, 0.5)),url('https://admin.hurenkangoedkoper.com/<?= $value->thePhoto ?>');">

        <div class="all" style="" >


            <section class="main-search-field" id="search-field" style="">



                <div class="ss" id="rents" style="top:-28%;;position: absolute; background-color:#0098ef;text-align: center; width: 18%; height: 50px;border-radius: 10px;"  >
                    <div class="media" id="medo" style="">




                        <i style="color: white;margin-right: 5px; padding-bottom: 50px;"class="fa fa-home"></i><h3 id="homs" style="">Rent Home</h3>


                    </div>
                </div>


                <div class="container ">


                    <form action="/prodacttts" method="GET">
                        <!--                justify-content-center-->


                        <div class="row justify-content-center" >
                            <input id="icon" class="anim-typewriter" name="term" style="border-top:1px solid #ccc;
        border-right:1px solid #ccc; border-bottom:1px solid #ccc;

" type="text" placeholder="Waa Wil je Wonen ?" >

                            <!--                  <img src="/public4/images/search_white_24dp.svg">-->

<!--                            <div class="col-lg-9 col-md-6" >-->
<!--                                <div class="at-col-default-mar">-->
<!---->
<!--                                </div>-->
<!--                            </div>-->


<!--                                <div class="at-col-default-mar">-->


<!--                                    <div class="at-col-default-mar no-mb">-->
                                        <button  style="border-radius: 8px; width: 80%;box-shadow: 1px 1px 1px grey;
" class="btn btn-default hvr-bounce-to-right" id="srch" onclick="send();" type="submit">Search</button>
<!--                                    </div>-->



<!--                            </div>-->
                        </div>


                </div>





        </div>
        </form>


        <!--        </div>-->


        </section>

    </div>

    </div>
<?php }?>


<!-- START SECTION ABOUT -->

<section class="featured portfolio">
    <div class="container"  >
        <div class="row">
            <div class="section-title col-md-5">
                <h3>Featured</h3>
                <h2> Properties</h2>
            </div>
        </div>
        <div class="row portfolio-items">
            <?php
            if (isset($prodact)){
            foreach ($prodact as $value){
                $linkss = $this->db->query("SELECT url FROM links WHERE content_id ='$value->id' AND page ='prodact'")->result_object();
                if ($linkss){
                    $link = $linkss[0]->url;

                }else{
                    $link ="#";
                }
                ?>

                <div class="item col-lg-4 col-md-6 col-xs-12 people rent" >
                    <div class="homes" >
                        <!-- homes img -->
                        <a href="<?= $link ?>" class="homes-img added-effect">
                            <div class="homes-tag button alt featured">Featured</div>
                            <div   class="homes-tag button sale rent">For Rent</div>

                            <img src="admin/<?= $value->thePhoto ?>" alt="home-1" class="img-responsive">
                        </a>
                        <!-- homes content -->
                        <div class="homes-content" style=" height: 350px">
                            <!-- homes address -->
                            <h3 style="height:50px"class="homes-address mb-3">
                                <a href="car-details.html">
                                    </i<span><?= $value->theTitle ?></span>
                                </a>
                            </h3>
                            <br>
                            <h5 style="height:50px" class="homes-address mb-3">
                                <a href="car-details.html">
                                    <i  class="fa fa-map-marker"></i><span><?= $value->theLocation ?></span>
                                </a>
                            </h5>
                            <br>
                            <i  style="color: #0098ef;" class="fa fa-object-group" aria-hidden="true"></i>
                            <span>Property type : <?= $value->theType ?></span>

                            <!-- homes List -->
                            <ul class="homes-list clearfix">


                                </li>


                                <li >
                                    <i class="fa fa-bed" aria-hidden="true"></i>
                                    <span>Room : <?= $value->theRoom ?></span>

                                </li>

                            </ul>
                            <!-- Price -->
                            <h3 style="float: right" class="title mt-3">
                                <a>€ <?= $value->thePrice ?></a>
                            </h3>
                            <div class="price-properties">


                                <!--                                <h3 class="title mt-3">-->
                                <!--                                    <a>--><?//= $value->theType ?><!--</a>-->
                                <!--                                </h3>-->
                            </div>
                        </div>
                    </div>
                </div>
            <?php }}?>



        </div>
    </div>
    <?php $link = $this->db->query("SELECT url FROM links WHERE content_id = 4 AND page ='menu_link'")->result_object();
    $links = $link[0]->url;
    ?>
    <li style="text-align: center;list-style-type: none; ">  <a href="<?=$links?>" style="width: 20%; padding-bottom:15px; padding-top: 15px"  class="btn btn-secondary">See More </a></li>
</section>
<br>
<br>
<br>
<?php foreach ($market as $key =>  $value){?>
    <?php if ($key %2 ==0){ ?>
        <section class="about-us">
            <div class="container">
                <div class="row">

                    <div class="col-lg-6 col-md-12 who-1">
                        <div>
                            <h2 class="text-left mb-4"><?= $value->theTitle ?></h2>
                        </div>
                        <div class="pftext">
                            <?= $value->theText ?>
                        </div>
                        <br>

                    </div>
                    <div class="col-lg-6 col-md-12 who">
                        <div class="wprt-image-video w50">
                            <img alt="<?= $value->alt ?>" src="admin/<?= $value->thePhoto ?>">
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <br>
    <?php } else { ?>

        <main class="services-2">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-12 who">
                        <div class="wprt-image-video w50">
                            <img alt="<?= $value->alt ?>" src="<?= $value->thePhoto ?>">
                        </div>
                    </div>



                    <div class="col-lg-6 col-md-12 who-1">
                        <div>
                            <br>
                            <h2 class="text-left mb-4"><?= $value->theTitle ?></h2>
                        </div>
                        <div class="pftext">
                            <?= $value->theText ?>
                        </div>

                    </div>


                </div>

            </div>
        </main>

    <?php }?>
<?php } ?>
<!-- START SECTION TESTIMONIALS -->
<!-- START SECTION SERVICES -->



<section class="services-home bg-white">
    <div class="container">
        <div class="section-title">
            <h3>Happy</h3>
            <h2>Customer</h2>
        </div>
        <div class="row">
            <?php foreach ($opinion as $value){?>
                <div class="col-lg-4 col-md-12 m-top-0 m-bottom-40">

                    <div class="service bg-light-2 border-1 border-light box-shadow-1 box-shadow-2-hover">
                        <div class="media">
                            <i class="<?= $value->theIcone?> bg-base text-white rounded-100 box-shadow-1 p-top-5 p-bottom-5 p-right-5 p-left-5"></i>
                        </div>
                        <div class="agent-section p-top-35 p-bottom-30 p-right-25 p-left-25">
                            <h4 class="m-bottom-15 text-bold-700"><?= $value->theName?></h4>
                            <p><?= $value->theText?></p>
                            <a class="text-base text-base-dark-hover text-size-13" href="#"><ul class="starts  mb-2">
                                    <li><i style="color: yellow" class="fa fa-star "></i>
                                    </li>
                                    <li><i class="fa fa-star"></i>
                                    </li>
                                    <li><i class="fa fa-star"></i>
                                    </li>
                                    <li><i class="fa fa-star"></i>
                                    </li>
                                    <li><i class="fa fa-star"></i>
                                    </li>
                                </ul></a>
                        </div>
                    </div>
                </div>
            <?php }?>


        </div>
    </div>
</section>

<script src="/public/js/jquery.js"></script>
<script>


    var searchInput = 'icon';

    $(document).ready(function () {
        var autocomplete;
        autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
            componentRestrictions:{country:["NL"]},
            types: ['geocode'],
        });

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var near_place = autocomplete.getPlace();
            document.getElementById('loc_lat').value = near_place.geometry.location.lat();
            document.getElementById('loc_long').value = near_place.geometry.location.lng();

            document.getElementById('latitude_view').innerHTML = near_place.geometry.location.lat();
            document.getElementById('longitude_view').innerHTML = near_place.geometry.location.lng();
        });
    });
</script>


<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->

<script>
    // $('#range').on("input", function() {
    //     $('.output').val(this.value +",000  $" );
    // }).trigger("change");
</script>

<!--<script>-->
<!--    $( "#srch" ).click(function() {-->
<!--        window.open("http://yusufabo.online/our-prodact", "_self");-->
<!--    });-->
<!--</script>-->
<!--<script type="text/javascript">-->
<!--    function send() {-->
<!--        var name = $("#search");-->
<!--        // var email = $("#email-c5de");-->
<!--        // var subject = $("#subject");-->
<!--        // var body = $("#message-c5de");-->
<!---->
<!--        if (isNotEmpty(name) ) {-->
<!--            $.ajax({-->
<!--                url: 'site/prodact',-->
<!--                method: 'GET',-->
<!--                dataType: 'json',-->
<!--                data: {-->
<!--                    name: name.val(),-->
<!--                    // email: email.val(),-->
<!--                    // subject: subject.val(),-->
<!--                    // body: body.val()-->
<!--                }, success: function (response) {-->
<!--                    window.open("http://yusufabo.online/our-prodact", "_self");-->
<!---->
<!---->
<!--                }-->
<!--            });-->
<!--        }-->
<!--    }-->
<!--</script>-->

<script>
// $( function() {
//   var availableTags = [
//
//     "Drenthe",
//     "Flevoland",
//     "Friesland",
//     "Gelderland",
//     "Groningen",
//     "Limburg",
//     "Noord-Brabant",
//     "Noord-Hollandl",
//     "Overijssel",
//     "Utrecht",
//     "Zeeland",
//     "Zuid-Holland",
//
//   ];
//   $( "#icon" ).autocomplete({
//     source: availableTags
//   });
// } );

    $( document ).ready(function() {
        // icon
        // $("#icon").autocomplete({
        //     source:"prodacttts",
        //     minLength:3
        // })
        //
        // $("#icon").data("ui-autocomplete")._renderItem = function (ul,item){
        //   console.log(item.theName);
        //
        //   $.each( item, function( key, value ) {
        //
        //     var $li = $("<li>");
        //     $li.html("<span> "+item.theName +"</span>");
        //     console.log(item.theName);
        //    return $li.appendTo(item.theName);
        // } ) ;
        //
        // }







    });

    // Add something to given element placeholder
    function addToPlaceholder(toAdd, el) {
        el.attr('placeholder', el.attr('placeholder') + toAdd);
        // Delay between symbols "typing"
        return new Promise(resolve => setTimeout(resolve, 100));
    }

    // Cleare placeholder attribute in given element
    function clearPlaceholder(el) {
        el.attr("placeholder", "");
    }

    // Print one phrase
    function printPhrase(phrase, el) {
        return new Promise(resolve => {
            // Clear placeholder before typing next phrase
            clearPlaceholder(el);
            let letters = phrase.split('');
            // For each letter in phrase
            letters.reduce(
                (promise, letter, index) => promise.then(_ => {
                    // Resolve promise when all letters are typed
                    if (index === letters.length - 1) {
                        // Delay before start next phrase "typing"
                        setTimeout(resolve, 1000);
                    }
                    return addToPlaceholder(letter, el);
                }),
                Promise.resolve()
            );
        });
    }

    // Print given phrases to element
    function printPhrases(phrases, el) {
        // For each phrase
        // wait for phrase to be typed
        // before start typing next
        phrases.reduce(
            (promise, phrase) => promise.then(_ => printPhrase(phrase, el)),
            Promise.resolve()
        );
    }

    // Start typing
    function run() {
        let phrases = [
            "Waa Wil je Wonen ...?",
            "Waa Wil je Wonen ...?",
            "Waa Wil je Wonen ...?",
            "Waa Wil je Wonen ...?",
            "Waa Wil je Wonen ...?",
            "Waa Wil je Wonen ...?",
        ];

        printPhrases(phrases, $('#icon'));
    }

    run();





</script>
<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
<!--<script src="/public4/jquery-ui-1.11.4/jquery-ui.min.js"></script>-->

