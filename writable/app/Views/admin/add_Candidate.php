<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bloom Solutions | Add Candidate</title>
  
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

<style>
:root{
    --bloom-purple:#4a00e0;
    --bloom-dark:#120038;
    --border:#e2e8f0;
    --bg:#f8fafc;
}

.candidate-form{
    width:100%;
    max-width:1100px;
    margin:25px auto;
    background:#fff;
    border:1px solid var(--border);
    border-radius:18px;
    box-shadow:0 6px 18px rgba(0,0,0,.06);
    overflow:hidden;
}

.form-header{
    padding:18px 25px;
    background:linear-gradient(135deg,#4a00e0,#120038);
    color:#fff;
}

.form-header h4{
    margin:0;
    font-weight:700;
    font-size:22px;
}

.form-body{
    padding:25px;
}

.form-row{
    display:flex;
    flex-wrap:wrap;
    margin-left:-10px;
    margin-right:-10px;
}

.form-col{
    width:50%;
    padding:0 10px;
}

.form-group{
    margin-bottom:18px;
}

label{
    font-weight:600;
    margin-bottom:7px;
    color:#334155;
}

.form-control{
    height:46px;
    border-radius:10px;
    border:1px solid #dbe3ec;
    font-size:14px;
}

.form-control:focus{
    border-color:#4a00e0;
    box-shadow:0 0 0 .15rem rgba(74,0,224,.12);
}

input[type=file]{
    padding:8px;
    height:auto;
}

.btn-submit{
    background:linear-gradient(135deg,#4a00e0,#120038);
    color:#fff;
    border:none;
    border-radius:10px;
    padding:11px 30px;
    font-weight:600;
    transition:.3s;
}

.btn-submit:hover{
    transform:translateY(-2px);
    color:#fff;
    box-shadow:0 10px 20px rgba(74,0,224,.20);
}

.alert{
    border-radius:10px;
}

@media(max-width:768px){
.form-col{
    width:100%;
}
}


.candidate-form{
    margin:20px auto 30px;
}

.candidate-form{
    width:100%;
    max-width:1000px;      /* Card width */
    margin:30px auto;       /* Centers the card horizontally */
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:18px;
    box-shadow:0 8px 20px rgba(0,0,0,.08);
}

.content{
    padding:25px 0;
}



.candidate-form{
    width:100%;
    max-width:1000px;
}

.content-wrapper{
    margin-top:60px !important;
    padding-top:10px !important;
}
.content-wrapper{
    padding-top:70px !important;   /* pushes everything below navbar */
}

.content-wrapper{
    padding-top:75px !important;
}

.content{
    padding-top:10px;
}
.content{
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
    min-height:100vh;
    background:#f8fafc;
}

.candidate-form{
    transform: translateX(80px);
}
</style>
<section class="content">
<div class="container">
<div class="candidate-form">

    <div class="form-header">
    <h4><i class="fas fa-user-plus mr-2"></i> Add Candidate</h4>
</div>

<div class="form-body">
    <?php if (session()->getFlashdata('success')): ?>

        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>

    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>

        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>

    <?php endif; ?>
    <form action="" method="post" enctype="multipart/form-data">

    <div class="form-row">
       
    <div class="form-col">
        <div class="form-group">
            <label>Candidate Type</label>
            <select name="candidate_role" class="form-control" required>
                <option value="">Select Candidate Type</option>
                <option value="HR">HR</option>
                <option value="EMP">EMP</option>
                <option value="INTERN">INTERN</option>
                <option value="MANAGER">MANAGER</option>
            </select>
        </div>
        </div>

        <div class="form-col">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
        </div>
         </div>

        <div class="form-col">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
        </div>
         </div>

        <div class="form-col">
        <div class="form-group">
            <label>Mobile Number</label>
            <input type="text"
                name="mobile_no"
                class="form-control"
                placeholder="Enter Mobile Number"
                maxlength="10"
                pattern="[0-9]{10}"
                required>
        </div>
       </div>

       <div class="form-col">
        <div class="form-group">
            <label>Experience Type</label>
            <select name="experience_type" class="form-control" required>
                <option value="">Select Experience Type</option>
                <option value="FRESHER">Fresher</option>
                <option value="EXPERIENCE">Experienced</option>
            </select>
        </div>
         </div>
<!-- 
        <div class="form-col">
        <div class="form-group">
            <label>Offer Letter</label>
            <input type="file" name="offer_letter" class="form-control" accept=".pdf,.doc,.docx">
        </div>
         </div> -->

          </div>

        <button type="submit" class="btn btn-submit">
            Submit
        </button>

    </form>

</div> <!-- form-body -->

</div> <!-- candidate-form -->

</div> <!-- container-fluid -->

</section>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

</body>
</html>