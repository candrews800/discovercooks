<?php $title = 'Ways To Earn'; ?>

@extends('content.templates.default')

@section('content')
    {{ ViewHelper::getNewBreadcrumbs(null, 'Earn Money') }}

    <h1 class="page-header">Overview</h1>
    <p class="lead">
        At DiscoverCooks, we use a revenue sharing model which pays our users the majority of the revenue we make. We share our revenue with our content creators because they are the ones responsible for our sites success and we think it's only fair that they share in the rewards.
    </p>
    <p>
        We pay out 80% of our total revenue to our content creators.
    </p>

    <img src="{{ url('assets/img/sharingpie.png') }}" class="img-responsive" style="margin: 60px 0;" />

    <p>Users are able to earn a portion of the 80% based on the content they create and how it performs. 40% of total revenue is given to each category, creation and performance. We offer the most ways to earn for our recipe creators but also provide a way for reviewers to as well.</p>

    <p>On the 1st and 15th of every month, we tally the stats for the previous period and credit each users account balance what they've earned.</p>

    <p>Payout is enabled once you're account balance reaches a minimum balance, currently set at $15.00. We offer payout through Paypal currently but are looking into new options for the future. <a href="{{ url('contact') }}">Please feel free to contact us if you would like to offer a better solution.</a></p>

    <h1 class="page-header" id="ways-to-earn">Ways To Earn</h1>

    <h3>Content Creation</h3>

    <p>The first and easiest way to earn is to simply create content. Each action a user makes relating to recipes on our site will earn a ticket based on the value we place on the action. At each pay period, we take the total tickets you've earned and divide it by the total tickets everyone has earned to get the percentage you'll receive. After each pay period, all tickets are wiped.</p>

    <p>In other words, each pay period the amount you earn will be based on how much you've contributed compared to the rest of the users on DiscoverCooks.</p>

    <p><strong>Ticket Table</strong></p>

    <p>The following table lists how many tickets you'll for each action you perform.</p>

    <div class="row">
        <div class="col-xs-12 col-md-8">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th class="text-center">Tickets</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Approved Recipe</td>
                        <td class="text-center">15</td>
                    </tr>
                    <tr>
                        <td>Submit Review</td>
                        <td class="text-center">1</td>
                    </tr>
                    <tr>
                        <td>Submit Review with Picture</td>
                        <td class="text-center">3</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <h3>Recipe Performance</h3>

    <p>The second way to earn money is based on how your recipes you've created perform. Half of the revenue allocated to users goes to recipe performance.</p>

    <p><strong>What is recipe performance?</strong></p>

    <p>Recipe performance is simply defined by how many people visit your recipes. The more people that visit your recipes, the better their performance. It's as simple as that.</p>

    <p>We allocate funds for recipe performance by taking the percentage of total page views that your recipes have generated compared to the overall views that all recipes have generated.</p>

    <p><strong>How can you improve your recipe performance?</strong></p>

    <p>There are a variety of ways to increase your recipe performance but the main ways are:</p>
    <ol>
        <li>Create high quality recipes. The more people save your recipes, the more they will come back to them in the future.</li>
        <li>Share your DiscoverCooks recipes with others. Either share your recipes on social media sites, or your blog.</li>
    </ol>

    <h1 class="page-header" id="faq">FAQ</h1>

    <p>
        <strong>
            Where can I check my balance?
        </strong>
    </p>
    <p>
        To see your balance you must be first logged in. Select 'My Account' from the Main Menu near the top of the screen.
    </p>

    <p>
        <strong>
            How can I request payment?
        </strong>
    </p>
    <p>
        You must first be logged in. Go to 'My Account' and select 'Payments Center'. From there you will be able to request a payment. Please note you must have an account balance of at least $15.00 to request a payment at this time.
    </p>

    <p>
        <strong>
            When can my account start earning money?
        </strong>
    </p>
    <p>
        You are eligible to earn immediately upon registering.
    </p>

    <p>
        <strong>
            There is a problem with my account. What should I do?
        </strong>
    </p>
    <p>
        If you are able to access your account and are having problems, please post on our Support Forum. If you are unable to access your account, please <a href="{{ url('contact') }}">Contact Us</a>.
    </p>

    <p>
        <strong>
            I have a question that was not asked here.
        </strong>
    </p>
    <p>
        We are sorry for the inconvenience. Please feel free to ask your question on the <a href="{{ url('forum') }}">Forum</a> or <a href="{{ url('contact') }}">Contact Us</a>.
    </p>
@stop

@section('javascript')
    <style>
        .fraction, .top, .bottom {
            padding: 0 5px;
        }

        .fraction {
            display: inline-block;
            text-align: center;
        }

        .bottom{
            border-top: 1px solid #000;
            display: block;
        }
    </style>

    <script>
        $('.fraction').each(function(key, value) {
            $this = $(this)
            var split = $this.html().split("/");
            if( split.length == 2 ){
                $this.html('<span class="top">'+split[0]+'</span><span class="bottom">'+split[1]+'</span>');
            }
        });
    </script>
@stop