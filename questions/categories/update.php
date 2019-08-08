<?php

/*
 * Page Title
 */
$title = 'Update :: Question Category';

/*
 * We're going to include our session
 * controller to check for an active
 * session.
 */
include __DIR__ . '/../../common/session.php';

/*
 * We're going to include our header which
 * is going to be common throughout our
 * entire application.
 */
include __DIR__ . '/../../common/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'update') {
    if ($query = $mysql->prepare("UPDATE `questions_categories` SET `name` = ?, `description` = ?, `active` = ? WHERE `id` = ?")) {
        if ($query->bind_param("ssii", $_POST['name'], $_POST['description'], $_POST['active'], $_POST['id'])) {
            if ($query->execute()) {
                $_SESSION['flash'] = '<div class="alert alert-success" role="alert">Question Category updated successfully!</div>';
            } else {
                $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to save question category!</div>';
            }
        } else {
            $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to save question category!</div>';
        }
    } else {
        $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to save question category!</div>';
    }
}

if (!($query = $mysql->prepare("SELECT * FROM questions_categories WHERE id = ?"))) {
    $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to prepare query!</div>';
} else {
    if (!$query->bind_param("i", $_GET['id'])) {
        $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to bind parameters to query!</div>';
    } else {
        $query->execute();

        $result = $query->get_result();

        if ($result->num_rows === 0) {
            $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Unable to find question category as referenced!</div>';
        } else {
            $category = $result->fetch_assoc();
        }
    }
}

?>

<div class="header">
    <div class="row">
        <div class="col-md-6">
            <h1><i class="far fa-question-circle"></i> Question Category :: Update</h1>
        </div>
        <div class="col-md-6">
            <div class="float-right"></div>
        </div>
    </div>
</div>

<?php if (!empty($_SESSION['flash'])) echo $_SESSION['flash']; unset($_SESSION['flash']); ?>

<?php if (isset($category)) { ?>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="box">
                <div class="box-body">
                    <form action="" method="post">
                        <input name="action" value="update" type="hidden">
                        <input name="id" value="<?php echo $category['id']; ?>" type="hidden">

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input name="name" type="text" class="form-control" id="name" aria-describedby="nameHelp" placeholder="Name" value="<?php echo $category['name']; ?>">
                            <small id="nameHelp" class="form-text text-muted">Enter a short identifier for this question.</small>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" rows="10" class="form-control" id="description" aria-describedby="descriptionHelp" placeholder="Enter the description here..."><?php echo $category['description']; ?></textarea>
                            <small id="descriptionHelp" class="form-text text-muted">Please provide your description above. Be as specific as possible and remember to check or grammar and spelling.</small>
                        </div>
                        <div class="form-group">
                            <label for="active">Active</label>
                            <select class="form-control selectpicker" name="active">
                                <option value="0"<?php echo ($category['active'] == 0 ? ' selected' : ''); ?>>No</option>
                                <option value="1"<?php echo ($category['active'] == 1 ? ' selected' : ''); ?>>Yes</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-block btn-primary"><i class="fas fa-save"></i> Save Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php

/*
 * Here, we're including our footer which
 * is going to be common throughout our
 * entire application just like the header.
 */
include __DIR__ . '/../../common/footer.php';

?>
