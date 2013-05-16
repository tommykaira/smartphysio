<?php // app/views/posts/search.ctp ?>
<h1>Blog posts</h1>
<?php 
    echo $form->create("Post",array('action' => 'search'));
    echo $form->input("q", array('label' => 'Search for'));
    echo $form->end("Search");
?>
<p><?php echo $html->link("Add Post", "/posts/add"); ?>
<table>
    <tr>
        <th>Id</th>
        <th>Title</th>
                <th>Action</th>
        <th>Created</th>
    </tr>

<!-- Here's where we loop through our $results array, printing out post info -->

<?php foreach ($results as $post): ?>
    <tr>
        <td><?php echo $post['Post']['id']; ?></td>
        <td>
            <?php echo $html->link($post['Post']['title'],'/posts/view/'.$post['Post']['id']);?>
                </td>
                <td>
            <?php echo $html->link(
                'Delete', 
                "/posts/delete/{$post['Post']['id']}", 
                null, 
                'Are you sure?'
            )?>
            <?php echo $html->link('Edit', '/posts/edit/'.$post['Post']['id']);?>
        </td>
        <td><?php echo $post['Post']['created']; ?></td>
    </tr>
<?php endforeach; ?>
</table> 