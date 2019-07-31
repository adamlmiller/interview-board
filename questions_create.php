<?php

/*
 * We're going to include our session
 * controller to check for an active
 * session.
 */
include 'common/session.php';

/*
 * We're going to include our header which
 * is going to be common throughout our
 * entire application.
 */
include 'common/header.php';

?>

<div class="header">
    <div class="row">
        <div class="col-md-6">
            <h1>Questions :: Create</h1>
        </div>
        <div class="col-md-6">
            <div class="float-right"></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-lg-12 col-xl-12">
        <div class="box">
            <div class="box-body">
                <form action="questions.php" method="post">
                    <input name="action" value="create" type="hidden">

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input name="name" type="text" class="form-control" id="name" aria-describedby="nameHelp" placeholder="Name">
                        <small id="nameHelp" class="form-text text-muted">Enter a short identifier for this question.</small>
                    </div>
                    <div class="form-group">
                        <label for="question">Question</label>
                        <textarea name="question" rows="10" class="form-control" id="question" aria-describedby="questionHelp" placeholder="Enter the question here..."></textarea>
                        <small id="questionHelp" class="form-text text-muted">Please provide your question above. Be as specific as possible and remember to check or grammar and spelling.</small>
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Question</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php

/*
 * Here, we're including our footer which
 * is going to be common throughout our
 * entire application just like the header.
 */
include 'common/footer.php';

?>
