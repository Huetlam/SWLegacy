<div class="card mx-auto col-12 col-md-8 col-lg-6 col-xl-4 p-0">
    <div class="card-header bg-red text-light">
    <h5>Upload CSV File: </h5>
    </div>
    <div class="card-body">
        <!-- allow the user to submit a csv file -->
        <form action="uploadingunitnames.php" method="post" enctype="multipart/form-data">
            <input type="file" class="form-control" name="csvfile" id="csvfile">

    </div>
    <div class="card-footer text-end bg-secondary">
        <input type="submit" class="btn bg-red text-light">
        </form>
    </div>
  </div>
