<?php

use App\Helpers\Formatter;

require 'partials/header.php';
?>
<form class="p-3" action="/word" method="POST">
    <div class="form-group">
        <label for="word">Enter a word</label>
        <input type="text" class="form-control word" id="word" name="word" placeholder="Your word">
    </div>
    <button class="btn btn-primary" type="submit">submit</button>
</form>
<?php
if (!empty($words)) : ?>
    <table class="table p-3">
        <tr>
            <th>Word</th>
            <th>Points</th>
            <th>Date</th>
            <th>Is it a palindrome</th>
        </tr>

        <?php foreach ($words as $word) : ?>
            <tr>
                <td><?= $word->word ?></td>
                <td><?= $word->points ?></td>
                <td><?= Formatter::formatDate($word->created_at) ?></td>
                <td><?= Formatter::formatPalindromeStatus($word->is_palindrome) ?></td>
            </tr>
        <?php endforeach; ?>

    </table>
<?php else : ?>
    <img style="width: 600px; display: block; margin: 0 auto;"
         src="https://www.meme-arsenal.com/memes/cd0750f8c21e6dd404efd2ec1f94cf15.jpg" alt="">
<?php endif;
require 'partials/footer.php';
?>
