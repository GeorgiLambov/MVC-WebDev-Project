<?php if(!empty($this->posts)): ?>
    <ul class="list-group col-lg-offset-1 col-lg-6 col-sm-6 col-xs-6">
        <?php foreach ($this->posts as $post) :?>
        <a href="/posts/view/<?= $post['id'] ?>">
            <li class="list-group-item">
              <span class="badge">#<?= $post['id']?></span>
                <span class="post-title"><?= htmlspecialchars($post['title'])?></span>
                <p class="right">
                    <?php foreach ($post['tags'] as $tag):  ?>
                    <span class="label label-info tag-right"><?php echo htmlspecialchars($tag['text'])?></span>&nbsp;
                    <?php endforeach; ?>
                </p>
            </li>
        </a>
        <br/>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
