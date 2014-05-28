<?php

return array(

  'index' => array(
    'headline' => 'Make your voice heard!',
    'content' => '<p>Whether you\'re an individual or part of a much larger organization, it\'s important to make sure your voice is heard in government. The White House has made it easier than ever through the <a href="https://petitions.whitehouse.gov" rel="external">We The People petitions site</a>. The Obama administration has pledged to respond to any petition which meets a certain threshold within the system; no more collecting paper signatures, sending them off to your elected officials, and hoping for a response!</p>
      <p>Unfortunately, until very recently signing a petition on We The People required creating an account on the White House website, which is anywhere from a minor inconvenience to a deterrent for privacy advocates. <strong>Now you can reach your constituents and collect signatures without the need for them to create accounts.</strong></p>
      <h2>Introducing campaigns</h2>
      <p>A <strong>campaign</strong> is a collection of one or more <strong>petitions</strong>. Campaigns are a great way to group related petitions together; your constituents have one URL to visit, the petitions are presented one by one with a "Sign this petition?" option, then a single signature form is presented at the end. Quick, simple, and effective.</p>
      <h2>Getting started</h2>
      <p>Getting started is a snap. Simply <a href=":signup_link">create a free account</a> for yourself or your organization, then create a new campaign. You can add things like a title, description, and (of course) petitions. Once you\'re ready, publish the campaign and share its URL across social media, your mailing list, etc. to spread the word! Petition The People is also built from the ground up with mobile and tablets in mind, so you can load it up and hit the streets!</p>',
  ),

  'api_key_required' => array(
    'page_title' => 'API Key Required',

    'headline' => 'An API key is required!',
    'content' => '<p>Before you can start collecting petitions, you need to <a href="#" rel="external">acquire an API key from We The People</a>.</p>
    <p>Once you have a key, simply add it to <code>app/config/:environment/wethepeople.php</code>.</p>',
  ),

  'about' => array(
    'page_title' => 'About Petition the People',

    'headline' => 'About',
    'content' => '<p>Petition the People was built by <a href="http://www.buckeyeinteractive.com/" rel="external">Buckeye Interactive</a> as part of the National Day of Civic Hacking at The White House May 28, 2014. It\'s available under the <a href="http://www.gnu.org/licenses/gpl-2.0.html" rel="external">GNU General Public License (version 2)</a>, making it free for you to copy, modify, and/or distribute this application. Its source is openly <a href="https://github.com/buckii/petition-the-people" rel="external">available on Github</a>.</p>
      <p>Under the hood, the application is written in PHP atop the <a href="http://laravel.com/" rel="external">Laravel application framework</a>.</p>'
  ),
);