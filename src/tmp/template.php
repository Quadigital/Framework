<!-- Keywords in URLs help a lot - e.g. - http://domainname.com/seo-services.html, where “SEO services” is the keyword
phrase you attempt to rank well for. But if you don't have the keywords in other parts of the document, don't rely on
having them in the URL.-->
<!doctype html>
<head>
    <meta charset="utf-8">

    <!-- Less and less important, especially for Google. Yahoo! and Bing still rely on them, so if you are optimizing for
    Yahoo! or Bing, fill these tags properly. In any case, filling these tags properly will not hurt, so do it. -->
    <meta name="keywords" content="Keyword1,Keyword2,Keyword3,Keyword4">

    <!-- This is one of the most important places to have a keyword because what is written inside the <title> tag shows in
    search results as your page title. The title tag must be short (6 or 7 words at most) and the the keyword must be near
    the beginning. -->
    <?php echo $this->title; ?>


</head>
<body>
<header>
    <!-- One more place where keywords count a lot. But beware that your page has actual text about the particular keyword.
    All heading tags are included (H1, H2, H3 etc). -->
    <h1>Page title</h1>
</header>
<section>
    <!-- Another very important factor you need to check. 3-7 % for major keywords is best, 1-2 for minor. Keyword density
    of over 10% is suspicious and looks more like keyword stuffing, than a naturally written text. -->
    <p>
        <!-- Keyword proximity measures how close in the text the keywords are. It is best if they are immediately one
        after the other (e.g. “dog food”), with no other words between them. For instance, if you have “dog” in the first
        paragraph and “food” in the third paragraph, this also counts but not as much as having the phrase “dog food”
        without any other words in between. Keyword proximity is applicable for keyword phrases that consist of 2 or more
        words. -->
        <!-- In addition to keywords, you can optimize for keyword phrases that consist of several words – e.g. “SEO
        services”. It is best when the keyword phrases you optimize for are popular ones, so you can get a lot of exact
        matches of the search string but sometimes it makes sense to optimize for 2 or 3 separate keywords (“SEO” and
        “services”) than for one phrase that might occasionally get an exact match. -->
        <?php echo $this->body; ?>
    </p>

    <!-- Spiders don't read images but they do read their textual descriptions in the <alt> tag, so if you have images on
    your page, fill in the <alt> tag with some keywords about them. -->
    <img alt="Keywords" width="" height=""/>

    <!-- Also very important, especially for the anchor text of inbound links, because if you have the keyword in the anchor
    text in a link from another site, this is regarded as getting a vote from this site not only about your site in general,
    but about the keyword in particular. -->
    <a href="#">Keywords</a>
</section>
<footer>
    <?php echo $this->footer; ?>
</footer>
</body>
</html>