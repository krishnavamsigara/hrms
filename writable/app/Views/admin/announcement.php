
<?php
$session = session();
$original_role = $session->get('user_category');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> Bloom Solutions | Announcement</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

<style>

body{
font-family:'Plus Jakarta Sans',sans-serif;
background:#f8fafc;
font-size:13px;
color:#334155;
}

/* Card */

.card-bloom{
border:1px solid #e2e8f0;
border-radius:14px;
background:#fff;
box-shadow:0 3px 6px rgba(0,0,0,0.05);
padding:15px;
}

/* Announcement Card */

.announce-item{
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius:16px;
    padding:18px;
    margin-bottom:16px;
    display:flex;
    gap:16px;
    transition:.3s;
    box-shadow:0 4px 12px rgba(15,23,42,.05);
}

.announce-item:hover{
    transform:translateY(-3px);
    box-shadow:0 12px 24px rgba(74,0,224,.12);
}
 .nav-pills .nav-link.active{ background:#007bff!important; color:#fff!important; }
.announce-icon{
width:52px;
height:52px;
border-radius:14px;
background:linear-gradient(135deg,#4a00e0,#111c43);
color:#fff;
display:flex;
align-items:center;
justify-content:center;
font-size:20px;
flex-shrink:0;
}

.announce-title{
font-size:17px;
font-weight:700;
color:#111827;
}
.announce-date{
font-size:12px;
color:#6b7280;
font-weight:500;
margin-top:3px;
}

.badge-dept{
background:#ede9fe;
color:#5b21b6;
padding:6px 12px;
border-radius:10px;
font-weight:600;
font-size:12px;
border:1px solid #d8b4fe;
}

/* Bloom Modal */

.modal-content{
    border:0;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 15px 40px rgba(17,28,67,.15);
}

.modal-header{
    background:linear-gradient(135deg,#111c43,#4a00e0);
    color:#fff;
    border-bottom:0;
    padding:18px 22px;
}

.modal-header .close{
    color:#fff;
    opacity:1;
    text-shadow:none;
}

.modal-title{
    font-weight:700;
    font-size:18px;
}

.modal-body{
    padding:22px;
    background:#fff;
}

.modal-footer{
    border-top:1px solid #eef2f7;
    padding:16px 22px;
    background:#fafcff;
}

.modal .form-group label{
    font-weight:600;
    color:#334155;
}

.modal .form-control,
.modal .custom-select{
    border:1px solid #dbe3ef;
    border-radius:10px;
    height:42px;
    box-shadow:none;
}

.modal textarea.form-control{
    min-height:110px;
    resize:none;
}

.modal .form-control:focus,
.modal .custom-select:focus{
    border-color:#4a00e0;
    box-shadow:0 0 0 .15rem rgba(74,0,224,.12);
}

.modal .btn-primary{
    background:#4a00e0;
    border-color:#4a00e0;
    border-radius:10px;
    padding:8px 18px;
}

.modal .btn-secondary{
    border-radius:10px;
    padding:8px 18px;
}
.btn-primary{
    background:linear-gradient(135deg,#111c43,#4a00e0);
    border:none;
    border-radius:10px;
    padding:8px 18px;
    font-weight:600;
}

.btn-primary:hover{
    background:linear-gradient(135deg,#4a00e0,#111c43);
}

.announce-item p{
    color:#475569;
    font-size:14px;
    margin-top:12px;
    line-height:1.7;
}
.btn-outline-primary,
.btn-outline-danger{
    border-radius:10px;
    width:36px;
    height:36px;
    padding:0;
}

.btn-outline-primary:hover{
    background:#4a00e0;
    border-color:#4a00e0;
}

.btn-outline-danger:hover{
    background:#ef4444;
    border-color:#ef4444;
}

</style>



<!-- Content -->
<div class="content-wrapper">
<section class="content p-3">

<div class="container-fluid">

<div class="card-bloom">

<div class="d-flex justify-content-between align-items-center mb-3">

<h6 class="font-weight-bold mb-0">
<i class="fas fa-bullhorn text-primary"></i>
Announcements
</h6>

<?php if (in_array($original_role, ['ADMIN', 'HR'])): ?>

<button class="btn btn-primary btn-sm"
        data-toggle="modal"
        data-target="#announcementModal">
    <i class="fas fa-plus"></i> Add Announcement
</button>

<?php endif; ?>

</div>

<div id="announcementList">

<?php if(!empty($announcement) && $announcement[0]['status'] != 'N') : ?>

<?php foreach($announcement as $row): ?>

<div class="announce-item">

    <div class="announce-icon">
        <i class="fas fa-bullhorn"></i>
    </div>

    <div style="flex:1">

        <div class="d-flex justify-content-between align-items-center">

            <div class="announce-title">
                <?= esc($row['Title']) ?>
            </div>

            <div class="d-flex align-items-center">

                <span class="badge-dept mr-2">
                    <?= esc($row['UserCategory']) ?>
                </span>

                <?php if (in_array($original_role, ['ADMIN', 'HR'])): ?>

                    <button
                        class="btn btn-sm btn-outline-primary rounded-circle mr-2"
                        title="Edit"
                        onclick="editAnnouncement(
                            <?= $row['AnnouncementID'] ?>,
                            '<?= esc($row['Title'], 'js') ?>',
                            '<?= esc($row['UserCategory'], 'js') ?>',
                            '<?= esc($row['Message'], 'js') ?>'
                        )">
                        <i class="fas fa-edit"></i>
                    </button>

                   <button
                    class="btn btn-sm btn-outline-danger rounded-circle"
                    title="Delete"
                    onclick="deleteAnnouncement(<?= $row['AnnouncementID'] ?>)">
                    <i class="fas fa-trash"></i>
                </button>

                <?php endif; ?>

            </div>

        </div>

        <div class="announce-date mt-1">
           Dated On : <?= date('d-m-Y', strtotime($row['CreatedOn'])) ?>
        </div>

        <p class="small mt-2 mb-0">
            <?= esc($row['Message']) ?>
        </p>

    </div>

</div>

<?php endforeach; ?>

<?php else: ?>

<div class="text-center py-4">
    <h5 class="font-weight-bold text-danger mb-0">
        <?= esc($announcement[0]['remarks'] ?? 'No announcements available') ?>
    </h5>
</div>

<?php endif; ?>

</div>

</div>

</div>

</div>


<!-- Modal -->

<div class="modal fade" id="announcementModal">

<div class="modal-dialog">

<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title">Announcement</h5>
<button class="close" data-dismiss="modal">&times;</button>
</div>

<div class="modal-body">

<input type="hidden" id="announcement_id">

<div class="form-group">
<label>Title</label>
<input type="text" id="title" class="form-control">
</div>

<div class="form-group">
<label>User Category</label>
<select id="dept" class="form-control">
    <option value="">Select User Category</option>
    <option>ALL</option>
    <option>ADMIN</option>
    <option>MANAGER</option>
    <option>EMP</option>
    <option>HR</option>
    <option>INTERN</option>
</select>
</div>

<!-- <div class="form-group">
<label>Date</label>
<input type="date" id="date" class="form-control">
</div> -->

<div class="form-group">
<label>Message</label>
<textarea id="message" class="form-control" rows="4"></textarea>
</div>

</div>

<div class="modal-footer">

<button class="btn btn-secondary" data-dismiss="modal">Cancel</button>

<button class="btn btn-primary" onclick="saveAnnouncement()">
<i class="fas fa-save"></i> Save
</button>

</div>

</div>
   </div>
    </section>
</div>


<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>

/* Default Announcements */


function saveAnnouncement(){

    $.ajax({

        url : "<?= base_url('admin/save_announcement') ?>",
        type : "POST",

        data : {

            announcement_id : $("#announcement_id").val(),
            title : $("#title").val(),
            user_category : $("#dept").val(),
            message : $("#message").val()

        },

        success:function(response){
              console.log(response);
    console.log(response.message);

            $('#announcementModal').modal('hide');

            Toastify({
                text: response.message,
                duration:3000,
                gravity:"top",
                position:"right",
                close:true,
                backgroundColor:"linear-gradient(to right,#00b09b,#96c93d)"
            }).showToast();

            setTimeout(function(){
                location.reload();
            },1000);
        }

    });

}

function editAnnouncement(id, title, category, message) {

    $("#announcement_id").val(id);
    $("#title").val(title);
    $("#dept").val(category);
    $("#message").val(message);

    $("#announcementModal").modal("show");
}

function deleteAnnouncement(id){

    deleteId = id;

    $("#deleteModal").modal("show");
}

$(document).on("click", "#confirmDelete", function () {

    $.ajax({

        url : "<?= base_url('admin/delete_announcement') ?>",
        type : "POST",

        data : {
            announcement_id : deleteId
        },

        success:function(response){

            $("#deleteModal").modal("hide");

            Toastify({
                text: response.message,
                duration:3000,
                gravity:"top",
                position:"right",
                close:true,
                backgroundColor:"linear-gradient(to right,#dc3545,#ff6b6b)"
            }).showToast();

            setTimeout(function(){
                location.reload();
            },1000);

        }
    });

});

</script>
<div class="modal fade" id="deleteModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-trash"></i> Delete Announcement
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    &times;
                </button>
            </div>

            <div class="modal-body text-center">
                Are you sure you want to delete this announcement?
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">
                    Cancel
                </button>

                <button class="btn btn-danger" id="confirmDelete">
                    Delete
                </button>
            </div>

        </div>
    </div>
      </div>

</body>
</html>

