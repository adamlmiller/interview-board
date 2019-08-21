<?php

$title = 'Update :: Questions';

include __DIR__ . '/../common/session.php';
include __DIR__ . '/../common/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'update') {
    if ($query = $mysql->prepare("UPDATE `questions` SET `name` = ?, `questions_categories_id` = ?, `question` = ?, `active` = ? WHERE `id` = ?")) {
        if ($query->bind_param("sisii", $_POST['name'], $_POST['questions_categories_id'], $_POST['question'], $_POST['active'], $_POST['id'])) {
            if ($query->execute()) {
                $_SESSION['flash'] = '<div class="alert alert-info" role="alert">Question updated successfully!</div>';
            } else {
                $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to save question!</div>';
            }
        } else {
            $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to save question!</div>';
        }
    } else {
        $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to save question!</div>';
    }
}

if (!($query = $mysql->prepare("SELECT * FROM questions WHERE id = ?"))) {
    $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to prepare query!</div>';
} else {
    if (!$query->bind_param("i", $_GET['id'])) {
        $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Error occurred when trying to bind parameters to query!</div>';
    } else {
        $query->execute();

        $result = $query->get_result();

        if ($result->num_rows === 0) {
            $_SESSION['flash'] = '<div class="alert alert-danger" role="alert">Unable to find question as referenced!</div>';
        } else {
            $question = $result->fetch_assoc();
        }
    }
}

?>

<div class="header">
    <div class="row">
        <div class="col-6">
            <h1><i class="fas fa-question"></i> Questions :: Update</h1>
        </div>
        <div class="col-6">
            <div class="float-right"></div>
        </div>
    </div>
</div>

<?php if (!empty($_SESSION['flash'])) echo $_SESSION['flash']; unset($_SESSION['flash']); ?>

<?php if (isset($question)) { ?>
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-body">
                    <form action="" id="frmUpdate" method="post">
                        <input name="action" value="update" type="hidden">
                        <input name="id" value="<?php echo $question['id']; ?>" type="hidden">

                        <div class="form-group">
                            <label for="active">Question Category</label>
                            <select class="form-control selectpicker" name="questions_categories_id">
                                <?php

                                if ($query = $mysql->query("SELECT id,name FROM questions_categories WHERE active = 1")) {
                                    if ($query->num_rows >= 1) {
                                        while ($category = $query->fetch_assoc()) {
                                            if ($question['questions_categories_id'] == $category['id']) {
                                                echo '<option value="' . $category['id'] . '" selected>' . $category['name'] . '</option>';
                                            } else {
                                                echo '<option value="' . $category['id'] . '">' . $category['name'] . '</option>';
                                            }
                                        }
                                    }
                                }

                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input name="name" type="text" class="form-control" id="name" aria-describedby="nameHelp" placeholder="Name" value="<?php echo $question['name']; ?>">
                            <small id="nameHelp" class="form-text text-muted">Enter a short identifier for this question.</small>
                        </div>
                        <div class="form-group">
                            <label for="question">Question</label>
                            <textarea name="question" rows="10" class="form-control" id="question" aria-describedby="questionHelp" placeholder="Enter the question here..."><?php echo $question['question']; ?></textarea>
                            <small id="questionHelp" class="form-text text-muted">Please provide your question above. Be as specific as possible and remember to check or grammar and spelling.</small>
                        </div>
                        <div class="form-group">
                            <label for="active">Active</label>
                            <select class="form-control selectpicker" name="active">
                                <option value="0"<?php echo ($question['active'] == 0 ? ' selected' : ''); ?>>No</option>
                                <option value="1"<?php echo ($question['active'] == 1 ? ' selected' : ''); ?>>Yes</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-6"><a class="btn btn-block btn-outline-dark" href="/questions/"><i class="fas fa-ban"></i> Cancel</a></div>
                            <div class="col-6"><button type="submit" class="btn btn-block btn-info"><i class="fas fa-save"></i> Save Question</button></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#frmUpdate").validate({
            rules: {
                name: {
                    required: true,
                    normalizer: function(value) {
                        return $.trim(value);
                    },
                    minlength: 2,
                    maxlength: 128
                },
                question: {
                    required: true,
                    normalizer: function(value) {
                        return $.trim(value);
                    },
                    minlength: 2
                }
            }
        });
    });
</script>

<?php include __DIR__ . '/../common/footer.php'; ?>
