<?php if(!empty($this->mostPopularTags)): ?>
    <div class="col-xs-4 col-lg-2 col-md-2">
        <ul class="nav nav-pills">
            <p>Most popular tags</p>
            <?php foreach ($this->mostPopularTags as $mostPopularTag) :?>
                <li>
                    <a href="/posts/tags/<?php echo htmlspecialchars($mostPopularTag['text']) ?>"><?php echo htmlspecialchars($mostPopularTag['text']) ?>
                        &nbsp;&nbsp;
                    <span class="badge">
                        #<?php echo htmlspecialchars($mostPopularTag['popularity']);?>
                   </span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<footer class="text-center col-lg-12 col-sm-12 col-xs-12">
    <hr/>
    <p>
    <a href="https://github.com/GeorgiLambov/MVC-WebDev-Project" target="_blank">Open source project</a>
    <em>&copy;  2015 - Author: Georgi Lambov</em><a href=""> Powered by PHP</a>
    </p>
</footer>
</div>
<script type="text/javascript" src="/content/bootstrap/js/bootstrap.js"></script>
<script type="text/javascript" src="/content/paging/public/javascript/zebra_pagination.js"></script>
</body>
</html>
