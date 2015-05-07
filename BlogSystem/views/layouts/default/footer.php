<?php if(isset($this->mostPopularTags)): ?>
    <div class="col-xs-2">
        <?php foreach ($mostPopularTags as $mostPopularTag) :?>
            <ul class="breadcrumb">
                <li class="active">
                    <?php echo htmlspecialchars($mostPopularTag['text']) ?>
                    &nbsp;&nbsp;
                    <em>
                        #<?php echo htmlspecialchars($mostPopularTag['popularity']);  ?>
                    </em>
                </li>
            </ul>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
</div>
<script type="text/javascript" src="/content/bootstrap/js/bootstrap.js"></script>
<script type="text/javascript" src="/content/paging/public/javascript/zebra_pagination.js"></script>
</body>
</html>
