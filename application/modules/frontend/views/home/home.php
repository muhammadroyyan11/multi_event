<!-- Hero Section Begin -->
<section class="hero-section set-bg" data-setbg="<?= base_url() ?>assets/frontEnd/img/hero.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="hero-text">
                    <span>5 to 9 may 2019, mardavall hotel, New York</span>
                    <h2>Change Your Mind<br /> To Become Sucess</h2>
                    <a href="#" class="primary-btn">Buy Ticket</a>
                </div>
            </div>
            <div class="col-lg-5">
                <img src="<?= base_url() ?>assets/frontEnd/img/hero-right.png" alt="">
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->


<!-- Home About Section Begin -->
<section class="home-about-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="ha-pic">
                    <img src="<?= base_url() ?>assets/frontEnd/img/h-about.jpg" alt="">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ha-text">
                    <h2>About Conference</h2>
                    <p>When I first got into the online advertising business, I was looking for the magical
                        combination that would put my website into the top search engine rankings, catapult me to
                        the forefront of the minds or individuals looking to buy my product, and generally make me
                        rich beyond my wildest dreams! After succeeding in the business for this long, I’m able to
                        look back on my old self with this kind of thinking and shake my head.</p>
                    <ul>
                        <li><span class="icon_check"></span> Write On Your Business Card</li>
                        <li><span class="icon_check"></span> Advertising Outdoors</li>
                        <li><span class="icon_check"></span> Effective Advertising Pointers</li>
                        <li><span class="icon_check"></span> Kook 2 Directory Add Url Free</li>
                    </ul>
                    <a href="#" class="ha-btn">Discover Now</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Home About Section End -->

<!-- latest BLog Section Begin -->
<section class="latest-blog spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Latest Event</h2>
                    <p>Do not miss anything topic abput the event</p>
                </div>
            </div>
        </div>
        <div class="row">
            <?php

            function formatDate($date) {
                $dateTime = new DateTime($date);
            
                $months = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                ];
            
                $day = $dateTime->format('d');
                $month = $months[(int)$dateTime->format('m')]; // Convert month to Indonesian
                $year = $dateTime->format('Y');
            
                return "$day $month $year";
            }

            
            foreach ($event as $key => $data) { ?>
                <div class="col-lg-4">
                    <div class="latest-item set-bg" data-setbg="<?= base_url() ?>assets/frontEnd/img/blog/latest-b/latest-2.jpg">
                        <div class="li-tag">Katergori</div>
                        <div class="li-text">
                            <h5><a href="<?= site_url('event_detail?id=' . $data->id)?>"><?= $data->name ?></a></h5>
                            <span><i class="fa fa-clock-o"></i> <?= formatDate($data->date_start) ?></span>
                        </div>
                    </div>
                </div>
            <?php }
            ?>


        </div>
    </div>
</section>
<!-- latest BLog Section End -->


<!-- Contact Section Begin -->
<section class="contact-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="section-title">
                    <h2>Location</h2>
                    <p>Get directions to our event center</p>
                </div>
                <div class="cs-text">
                    <div class="ct-address">
                        <span>Address:</span>
                        <p>01 Pascale Springs Apt. 339, NY City <br />United State</p>
                    </div>
                    <ul>
                        <li>
                            <span>Phone:</span>
                            (+12)-345-67-8910
                        </li>
                        <li>
                            <span>Email:</span>
                            info.colorlib@gmail.com
                        </li>
                    </ul>
                    <div class="ct-links">
                        <span>Website:</span>
                        <p>https://conference.colorlib.com</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="cs-map">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d52901.38789495531!2d-118.19465514866786!3d34.03523211493029!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c2cf71ad83ff9f%3A0x518b28657f4543b7!2sEast%20Los%20Angeles%2C%20CA%2C%20USA!5e0!3m2!1sen!2sbd!4v1579763856144!5m2!1sen!2sbd"
                        height="400" style="border:0;" allowfullscreen=""></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section End -->