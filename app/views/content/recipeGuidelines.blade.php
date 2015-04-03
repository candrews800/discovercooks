<?php $title = 'Recipe Guidelines'; ?>

@extends('content.templates.default')

@section('content')
    {{ ViewHelper::getNewBreadcrumbs(null, 'Recipe Guidelines') }}

    <h1 class="page-header">Recipe Guidelines</h1>

    <p>
        Please follow the below guidelines when creating your recipes. Recipes not following the guidelines may be deleted, not able to be seen by others, and/or may compromise the ability of the recipe owner to earn or request money based on the severity of the infraction.
    </p>

    <p>
        Note: All recipes are private by default until they are reviewed.
    </p>

    <h3>
        Copyright Recipes
    </h3>
    <p>
        At DiscoverCooks, we have a zero tolerance policy for not adhering to copyright laws regarding recipes. While recipes themselves are not subject to copyright law, posting any associated images or non-essential text that was not created by you is strictly prohibited.
    </p>

    <h3>
        Duplicate Recipes
    </h3>
    <p>
        Please search for the recipe you want to post before submitting. While we understand there are a lot of variations of recipes, if you are simply modifying a quantity and not bringing anything new to a dish, chances are it will not pass review.
    </p>

    <h3>
        Quality
    </h3>
    <p>
        Spelling issues, grammar problems, and general bad quality posts will not be accepted.
    </p>

    <h3>
        Recipe Image
    </h3>
    <p>
        All recipe images must be at least 1280 x 720 to be posted on DiscoverCooks. This ensures that all recipes are able to be featured as well as fit with the theme of the site.
    </p>
@stop