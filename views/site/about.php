<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="margin-left: 20%;margin-right: 20%">
    <!-- Introduction Row -->
    <div class="row">
        <div class="col-lg-12">
            <h1>About Us
                <small>It's Nice to Meet You!</small>
            </h1>
            <p>HealthExplorer ถูกพัฒนาขึ้นครั้งแรกในปี พ.ศ.2553 บน Windows Platform. (<a href="https://www.youtube.com/watch?v=N9YgFalNjhI" target="_blank">ชมคลิปบน Youtube</a>)
            ต่อมาในปี 2559 ได้พัฒนาเป็น Web บนเทคโนโลยีการพัฒนาเว็บยุคใหม่ มีวัตถุประสงค์การพัฒนาเพื่อเป็นศูนย์กลางข้อมูลด้านสุขภาพระดับจังหวัด แต่สามารถนำไปใช้ในระดับที่กว้างกว่า หรือเล็กกว่าระดับจังหวัดได้
             HealthExplorer มีแนวคิดให้ผู้ใช้ สามารถจัดทำรายงานเองได้ โดยมีเครื่องมือที่จะช่วยให้ User สามารถสร้างตารางรายงาน สร้างกราฟได้ด้วยตัวเอง และสามารถ Group ข้อมูลเป็นระดับ เขต จังหวัด อำเภอ ตำบล หมู่บ้าน สถานบริการ ให้โดยอัตโนมัติ
             ซึ่งเรามุ่งเน้นความง่ายต่อการใช้งานของ User และ User สารมารถสร้างระบบสารสนเทศได้ตัวตัวเองโดยไม่ต้องมีความรู้ด้าน Programing
            ตามแนวคิดของ Web 2.0 Contents มาจาก User และเพื่อต้องการให้การพัฒนาระบบสารสนเทศด้านสุขภาพ พัฒนาไปอย่างรวดเร็วยิ่งขึ้น</p>
        </div>
    </div>

    <!-- Team Members Row -->
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Our Team</h2>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 text-center">
            <?= Html::img('@web/images/team/56068717d014c.jpg', ['class'=>'img-circle img-responsive img-center']);?>

            <h3>Shongpon Piapengton
                <small>Project Manager & Core Programing</small>
            </h3>
            <p>What does this team member to? Keep it short! This is also a great spot for social links!</p>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 text-center">
            <?= Html::img('@web/images/team/55f799744a6a4.jpg', ['class'=>'img-circle img-responsive img-center']);?>
            <h3>ศุภชัย เงางาม
                <small>Module Programing</small>
            </h3>
            <p>What does this team member to? Keep it short! This is also a great spot for social links!</p>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 text-center">
            <?= Html::img('@web/images/team/5747c20f6c64f.jpg', ['class'=>'img-circle img-responsive img-center']);?>
            <h3>จิระเดช ช่างสาย
                <small>Module Programing</small>
            </h3>
            <p>What does this team member to? Keep it short! This is also a great spot for social links!</p>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 text-center">
            <img class="img-circle img-responsive img-center" src="http://placehold.it/200x200" alt="">
            <h3>It's you.
                <small>Join us</small>
            </h3>
            <p>What does this team member to? Keep it short! This is also a great spot for social links!</p>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 text-center">
            <img class="img-circle img-responsive img-center" src="http://placehold.it/200x200" alt="">
            <h3>It's you.
                <small>Join us</small>
            </h3>
            <p>What does this team member to? Keep it short! This is also a great spot for social links!</p>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 text-center">
            <img class="img-circle img-responsive img-center" src="http://placehold.it/200x200" alt="">
            <h3>It's you.
                <small>Join us</small>
            </h3>
            <p>What does this team member to? Keep it short! This is also a great spot for social links!</p>
        </div>
    </div>
</div>