<?php
/*
Template Name: Dashboard Home
*/
?>
<?php 
get_header();
$user = wp_get_current_user();
?>
<div id="collapse-info"  class="collapse">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-11">
                <h4>Welcome to the team!</h4>
                <p>Within your dashboard, you’ll find investor-approved content that can be customized and shared, additional training on specific digital platforms, a launchpad to create and deploy campaigns, as well as a feed of third party insights. If you have any questions about your dashboard, don’t hesitate to give us a call.</p>
            </div>
            <div class="col-12 col-md-1 d-flex justify-content-end align-items-start">
                <a href="#" class="close-collapse"><i class="fa fa-times"></i></a>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="white-element">
                <div class="row">
                    <div class="col-12">
                        <h3><?php echo $user->user_nicename; ?>, you’re crushing it this week!</h3>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="general-holder right-border d-flex flex-column justify-content-center align-items-center">
                            <p>You’ve read</p>
                            <label>11</label>
                            <p>next-level insights</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="general-holder right-border d-flex flex-column justify-content-center align-items-center">
                            <p>You’ve taken</p>
                            <label>3</label>
                            <p>lessons</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="general-holder d-flex flex-column justify-content-center align-items-center">
                            <p>You’ve shared</p>
                            <label>16</label>
                            <p>items with clients</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-7">
            <div class="white-element mb-100">
                <div class="row">
                    <div class="col-12">
                        <h4>Content for your clients</h4>
                    </div>
                    <!--/grey/-->
                    <div class="col-12">
                        <div class="grey-box">
                            <div class="row no-gutters">
                                <div class="col-3">
                                    <a href="dashboard-investment.html"><div class="post-image" style="background-image: url(./dist/img/img1.png);"></div></a>
                                </div>
                                <div class="col-9 d-flex justify-content-center align-items-center pl-0">
                                    <div class="row w-100">
                                        <div class="col-7 d-flex flex-column justify-content-center align-items-start">
                                            <a href="dashboard-investment.html"><p class="bold">About the market correction</p></a>
                                            <a href="dashboard-investment.html"><p>Ttempor incididunt ut labore et dolore magna.</p></a>
                                        </div>
                                        <div class="col-5 d-flex flex-row justify-content-end align-items-center">
                                            <span>Inactive</span>
                                            <a class="borders" href="#">View</a>
                                            <a href="#">Edit</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="grey-box">
                            <div class="row no-gutters">
                                <div class="col-3">
                                    <a href="dashboard-investment.html"><div class="post-image" style="background-image: url(./dist/img/img2.png);"></div></a>
                                </div>
                                <div class="col-9 d-flex justify-content-center align-items-center pl-0">
                                    <div class="row w-100">
                                        <div class="col-7 d-flex flex-column justify-content-center align-items-start">
                                            <a href="dashboard-investment.html"><p class="bold">About the market correction</p></a>
                                            <a href="dashboard-investment.html"><p>Ttempor incididunt ut labore et dolore magna.</p></a>
                                        </div>
                                        <div class="col-5 d-flex flex-row justify-content-end align-items-center">
                                            <span class="active">Active</span>
                                            <a class="borders" href="#">View</a>
                                            <a href="#">Edit</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="grey-box">
                            <div class="row no-gutters">
                                <div class="col-3">
                                    <a href="dashboard-investment.html"><div class="post-image" style="background-image: url(./dist/img/img3.png);"></div></a>
                                </div>
                                <div class="col-9 d-flex justify-content-center align-items-center pl-0">
                                    <div class="row w-100">
                                        <div class="col-7 d-flex flex-column justify-content-center align-items-start">
                                            <a href="dashboard-investment.html"><p class="bold">About the market correction</p></a>
                                            <a href="dashboard-investment.html"><p>Ttempor incididunt ut labore et dolore magna.</p></a>
                                        </div>
                                        <div class="col-5 d-flex flex-row justify-content-end align-items-center">
                                            <span class="active">Active</span>
                                            <a class="borders" href="#">View</a>
                                            <a href="#">Edit</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="grey-box">
                            <div class="row no-gutters">
                                <div class="col-3">
                                    <a href="dashboard-investment.html"><div class="post-image" style="background-image: url(./dist/img/img4.png);"></div></a>
                                </div>
                                <div class="col-9 d-flex justify-content-center align-items-center pl-0">
                                    <div class="row w-100">
                                        <div class="col-7 d-flex flex-column justify-content-center align-items-start">
                                            <a href="dashboard-investment.html"><p class="bold">About the market correction</p></a>
                                            <a href="dashboard-investment.html"><p>Ttempor incididunt ut labore et dolore magna.</p></a>
                                        </div>
                                        <div class="col-5 d-flex flex-row justify-content-end align-items-center">
                                            <span class="active">Active</span>
                                            <a class="borders" href="#">View</a>
                                            <a href="#">Edit</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="grey-box">
                            <div class="row no-gutters">
                                <div class="col-3">
                                    <a href="dashboard-investment.html"><div class="post-image" style="background-image: url(./dist/img/img5.png);"></div></a>
                                </div>
                                <div class="col-9 d-flex justify-content-center align-items-center pl-0">
                                    <div class="row w-100">
                                        <div class="col-7 d-flex flex-column justify-content-center align-items-start">
                                            <a href="dashboard-investment.html"><p class="bold">About the market correction</p></a>
                                            <a href="dashboard-investment.html"><p>Ttempor incididunt ut labore et dolore magna.</p></a>
                                        </div>
                                        <div class="col-5 d-flex flex-row justify-content-end align-items-center">
                                            <span class="active">Active</span>
                                            <a class="borders" href="#">View</a>
                                            <a href="#">Edit</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/*/-->
                    <div class="col-12">
                        <div class="link-box d-flex flex-row justify-content-end align-items-center">
                            <a href="dashboard-list.html" class="read-more">See More <img src="./dist/img/arrow-right.png"></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="white-element mb-100">
                <div class="row">
                    <div class="col-12">
                        <h4>Training for you</h4>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="white-element strategies-holder status-new d-flex flex-column justify-content-start align-items-center">
                            <img src="./dist/img/icon-hands.png" alt="icon-hands"/>
                            <div class="point-holder d-flex flex-row justify-content-center align-items-center">
                                <div class="point-dot"></div>
                                <div class="point-dot"></div>
                                <div class="point-dot"></div>
                                <div class="point-dot"></div>
                                <div class="point-dot"></div>
                                <div class="point-dot"></div>
                            </div>
                            <p>Strategies on How to Sell</p>
                            <p class="grey">New</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="white-element strategies-holder status-started d-flex flex-column justify-content-start align-items-center">
                            <img src="./dist/img/icon-hands.png" alt="icon-hands"/>
                            <div class="point-holder d-flex flex-row justify-content-center align-items-center">
                                <div class="point-full"></div>
                                <div class="point-full"></div>
                                <div class="point-half"></div>
                                <div class="point-dot"></div>
                                <div class="point-dot"></div>
                                <div class="point-dot"></div>
                            </div>
                            <p>Strategies on Advertising</p>
                            <p class="grey">In Progress</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="white-element strategies-holder status-started d-flex flex-column justify-content-start align-items-center">
                            <img src="./dist/img/icon-hands.png" alt="icon-hands"/>
                            <div class="point-holder d-flex flex-row justify-content-center align-items-center">
                                <div class="point-full"></div>
                                <div class="point-full"></div>
                                <div class="point-half"></div>
                                <div class="point-dot"></div>
                                <div class="point-dot"></div>
                                <div class="point-dot"></div>
                            </div>
                            <p>Strategies on Marketing</p>
                            <p class="grey">In Progress</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="white-element strategies-holder status-finished d-flex flex-column justify-content-start align-items-center">
                            <img src="./dist/img/icon-hands.png" alt="icon-hands"/>
                            <div class="point-holder d-flex flex-row justify-content-center align-items-center">
                                <div class="point-full"></div>
                                <div class="point-full"></div>
                                <div class="point-full"></div>
                                <div class="point-full"></div>
                                <div class="point-full"></div>
                                <div class="point-full"></div>
                            </div>
                            <p>Strategies on How to Sell</p>
                            <p class="grey">Completed</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="white-element strategies-holder status-finished d-flex flex-column justify-content-start align-items-center">
                            <img src="./dist/img/icon-hands.png" alt="icon-hands"/>
                            <div class="point-holder d-flex flex-row justify-content-center align-items-center">
                                <div class="point-full"></div>
                                <div class="point-full"></div>
                                <div class="point-full"></div>
                                <div class="point-full"></div>
                                <div class="point-full"></div>
                                <div class="point-full"></div>
                            </div>
                            <p>Strategies on How to Sell</p>
                            <p class="grey">Completed</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="white-element strategies-holder status-finished d-flex flex-column justify-content-start align-items-center">
                            <img src="./dist/img/icon-hands.png" alt="icon-hands"/>
                            <div class="point-holder d-flex flex-row justify-content-center align-items-center">
                                <div class="point-full"></div>
                                <div class="point-full"></div>
                                <div class="point-full"></div>
                                <div class="point-full"></div>
                                <div class="point-full"></div>
                                <div class="point-full"></div>
                            </div>
                            <p>Strategies on How to Sell</p>
                            <p class="grey">Completed</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="link-box d-flex flex-row justify-content-end align-items-center">
                            <a href="#" class="read-more">See More <img src="./dist/img/arrow-right.png"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12 col-md-5">
            <div class="white-element right-holder">
                <div class="row">
                    <div class="col-12 d-flex flex-row justify-content-between align-items-center">
                        <h4>7 Things to Do This Week</h4>
                        <span>Jul 1st - Jul 7th</span>
                    </div>

                    <div class="col-12">
                        <div class="top-border">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="review" aria-selected="true">Review</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="read-tab" data-toggle="tab" href="#read" role="tab" aria-controls="read" aria-selected="false">Read</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="execute-tab" data-toggle="tab" href="#execute" role="tab" aria-controls="execute" aria-selected="false">Execute</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="share-tab" data-toggle="tab" href="#share" role="tab" aria-controls="share" aria-selected="false">Share</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="review-tab">
                                    <div class="col-12 px-0">
                                        <div class="grey-box">
                                            <div class="row no-gutters">
                                                <div class="col-3">
                                                    <div class="post-image" style="background-image: url(./dist/img/strategy1.png);"></div>
                                                </div>
                                                <div class="col-9 d-flex justify-content-center align-items-center pl-0">
                                                    <div class="row w-100">
                                                        <p>Email response strategy</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grey-box">
                                            <div class="row no-gutters">
                                                <div class="col-3">
                                                    <div class="post-image" style="background-image: url(./dist/img/strategy2.png);"></div>
                                                </div>
                                                <div class="col-9 d-flex justify-content-center align-items-center pl-0">
                                                    <div class="row w-100">
                                                        <p>Man in gray blazer raising drinking glass while sitting on sofa</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grey-box">
                                            <div class="row no-gutters">
                                                <div class="col-3">
                                                    <div class="post-image" style="background-image: url(./dist/img/strategy3.png);"></div>
                                                </div>
                                                <div class="col-9 d-flex justify-content-center align-items-center pl-0">
                                                    <div class="row w-100">
                                                        <p>Sidewalk at in Austin is really beautiful</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grey-box">
                                            <div class="row no-gutters">
                                                <div class="col-3">
                                                    <div class="post-image" style="background-image: url(./dist/img/strategy4.png);"></div>
                                                </div>
                                                <div class="col-9 d-flex justify-content-center align-items-center pl-0">
                                                    <div class="row w-100">
                                                        <p>Room is a personal space for anyone</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grey-box">
                                            <div class="row no-gutters">
                                                <div class="col-3">
                                                    <div class="post-image" style="background-image: url(./dist/img/strategy5.png);"></div>
                                                </div>
                                                <div class="col-9 d-flex justify-content-center align-items-center pl-0">
                                                    <div class="row w-100">
                                                        <p>Flying to work is the only way to go</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grey-box">
                                            <div class="row no-gutters">
                                                <div class="col-3">
                                                    <div class="post-image" style="background-image: url(./dist/img/strategy6.png);"></div>
                                                </div>
                                                <div class="col-9 d-flex justify-content-center align-items-center pl-0">
                                                    <div class="row w-100">
                                                        <p>Why you should relax more at work</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grey-box">
                                            <div class="row no-gutters">
                                                <div class="col-3">
                                                    <div class="post-image" style="background-image: url(./dist/img/strategy7.png);"></div>
                                                </div>
                                                <div class="col-9 d-flex justify-content-center align-items-center pl-0">
                                                    <div class="row w-100">
                                                        <p>What active lunch breaks can mean for your health</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="read" role="tabpanel" aria-labelledby="read-tab">
                                    <div class="col-12 px-0">
                                        <div class="grey-box">
                                            <div class="row no-gutters">
                                                <div class="col-3">
                                                    <div class="post-image" style="background-image: url(./dist/img/strategy2.png);"></div>
                                                </div>
                                                <div class="col-9 d-flex justify-content-center align-items-center pl-0">
                                                    <div class="row w-100">
                                                        <p>First interaction strategy</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="execute" role="tabpanel" aria-labelledby="execute-tab">
                                    <div class="col-12 px-0">
                                        <div class="grey-box">
                                            <div class="row no-gutters">
                                                <div class="col-3">
                                                    <div class="post-image" style="background-image: url(./dist/img/strategy1.png);"></div>
                                                </div>
                                                <div class="col-9 d-flex justify-content-center align-items-center pl-0">
                                                    <div class="row w-100">
                                                        <p>Email response strategy</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 px-0">
                                        <div class="grey-box">
                                            <div class="row no-gutters">
                                                <div class="col-3">
                                                    <div class="post-image" style="background-image: url(./dist/img/strategy2.png);"></div>
                                                </div>
                                                <div class="col-9 d-flex justify-content-center align-items-center pl-0">
                                                    <div class="row w-100">
                                                        <p>First interaction strategy</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 px-0">
                                        <div class="grey-box">
                                            <div class="row no-gutters">
                                                <div class="col-3">
                                                    <div class="post-image" style="background-image: url(./dist/img/strategy3.png);"></div>
                                                </div>
                                                <div class="col-9 d-flex justify-content-center align-items-center pl-0">
                                                    <div class="row w-100">
                                                        <p>First meeting strategy</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="share" role="tabpanel" aria-labelledby="share-tab">
                                    <div class="col-12 px-0">
                                        <div class="grey-box">
                                            <div class="row no-gutters">
                                                <div class="col-3">
                                                    <div class="post-image" style="background-image: url(./dist/img/strategy3.png);"></div>
                                                </div>
                                                <div class="col-9 d-flex justify-content-center align-items-center pl-0">
                                                    <div class="row w-100">
                                                        <p>First meeting strategy</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="white-element webinars-holder">
                <div class="row">
                    <div class="col-12">
                        <h4>Upcoming Webinars</h4>
                    </div>
                    <div class="col-12">
                        <div class="top-border">
                            <div class="upcoming-accordion" id="accordion-upcoming">
                                <div class="card">
                                    <div class="card-header active" id="heading-1">
                                        <div class="row">
                                            <div class="col-12">
                                                <h5>Understanding instratutional trading</h5>
                                            </div>
                                            <div class="col-12 col-md-6 d-flex flex-row justify-content-start align-items-center">
                                                <p>4:30pm</p>
                                                <p class="border-left">12/09/2019</p>
                                            </div>
                                            <div class="col-12 col-md-6 d-flex flex-row justify-content-end align-items-center">
                                                <button class="btn btn-link card-button" type="button" data-toggle="collapse" data-target="#collapse-1" aria-expanded="true" aria-controls="collapse-1" data-heading="heading-1">
                                                    VIEW DETAILS
                                                </button>
                                            </div>
                                        </div>


                                    </div>

                                    <div id="collapse-1" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion-upcoming">
                                        <div class="card-body">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                        </div>
                                    </div>
                                </div>


                                <div class="card">
                                    <div class="card-header"  id="heading-2">
                                        <div class="row">
                                            <div class="col-12">
                                                <h5>Why Investors need to look abroad </h5>
                                            </div>
                                            <div class="col-12 col-md-6 d-flex flex-row justify-content-start align-items-center">
                                                <p>4:30pm</p>
                                                <p class="border-left">12/09/2019</p>
                                            </div>
                                            <div class="col-12 col-md-6 d-flex flex-row justify-content-end align-items-center">
                                                <button class="btn btn-link card-button" type="button" data-toggle="collapse" data-target="#collapse-2" aria-expanded="false" aria-controls="collapse-2" data-heading="heading-2">
                                                    VIEW DETAILS
                                                </button>
                                            </div>
                                        </div>


                                    </div>

                                    <div id="collapse-2" class="collapse" aria-labelledby="headingOne" data-parent="#accordion-upcoming">
                                        <div class="card-body">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php 
get_footer();
