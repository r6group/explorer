<?php

use yii\helpers\Url;
use common\models\Profile;

$profile = 0;
if (!\Yii::$app->user->isGuest) {
    $profile = Profile::findOne(['user_id' => Yii::$app->user->identity->getId()])->id;
}





function isActive($path, $math_all = false) {
    $param_r = Url::current();

    if ($math_all == true) {
        return ($param_r == $path) ? ' active' : '';
    } else {
        return (strpos($param_r, $path) == true) ? ' active' : '';
    }

}
?>

<ul class="nav nav-pills nav-stacked nav-quirk">
    <li class="<?=isActive('/work/index/', true)?>"><a href="/work/index/"><i class="fa fa-home"></i><span>Home</span></a></li>

    <li class="nav-parent<?=isActive('/saraban/default')?>">
        <a href=""><i class="fa fa-file-text"></i><span>สารบรรณ</span> <span class="badge badge-info">21</span></a>
        <ul class="children">
            <li class="<?=isActive('/saraban/default/inbox')?>"><a href="<?= Url::toRoute(['/saraban/default/inbox']); ?>">หนังสือเข้า รอลงรับ <span class="badge badge-info">21</span></a></li>
            <li class="<?=isActive('/saraban/default/waiting')?>"><a href="<?= Url::toRoute(['/saraban/default/waiting/']); ?>">ลงรับแล้ว รอดำเนินการ <span class="badge badge-info">5</span></a></li>
            <li class="<?=isActive('/saraban/default/done')?>"><a href="<?= Url::toRoute(['/saraban/default/done']); ?>">ลงรับแล้ว จำหน่าย <span class="badge badge-info">854</span></a></li>
            <li class="<?=isActive('/saraban/default/create')?>"><a href="<?= Url::toRoute(['/saraban/default/outbox']); ?>">ส่งหนังสือส่ง</a></li>
            <li class="<?=isActive('/saraban/default/search')?>"><a href="<?= Url::toRoute(['/saraban/doc/create']); ?>">ค้นหาหนังสือ</a></li>

        </ul>
    </li>
    <li class="nav-parent<?=isActive('/hrm/default')?>">
        <a href=""><i class="fa fa-users"></i><span>บุคลากร</span></a>
        <ul class="children">
            <li class="<?=isActive('/hrm/default/view')?>"><a href="<?= Url::toRoute(['/hrm/default/view', 'id'=> $profile]); ?>">ข้อมูลของฉัน</a></li>
            <li class="<?=isActive('/hrm/default/index')?>"><a href="<?= Url::toRoute('/hrm/default/index'); ?>">ค้นหาบุคลากร</a></li>
            <li><a href="<?= Url::toRoute('/hrm/workgroup/index'); ?>">โครงสร้างองค์กร</a></li>
            <li><a href="wysiwyg.html">การพัฒนาบุคลากร</a></li>
        </ul>
    </li>
    <li class="nav-parent"><a href=""><i class="fa fa-money"></i><span>งบประมาณ/การเงิน</span></a>
        <ul class="children">
            <li><a href="buttons.html">Buttons</a></li>
            <li><a href="icons.html">Icons</a></li>
            <li><a href="typography.html">Typography</a></li>
            <li><a href="alerts.html">Alerts &amp; Notifications</a></li>
            <li><a href="tabs-accordions.html">Tabs &amp; Accordions</a></li>
            <li><a href="sliders.html">Sliders</a></li>
            <li><a href="graphs.html">Graphs &amp; Charts</a></li>
            <li><a href="panels.html">Panels</a></li>
            <li><a href="extras.html">Extras</a></li>
        </ul>
    </li>
    <li class="nav-parent"><a href=""><i class="fa fa-ambulance"></i><span>พัสดุ-ครุภัณฑ์</span></a>
        <ul class="children">
            <li><a href="basic-tables.html">Basic Tables</a></li>
            <li><a href="data-tables.html">Data Tables</a></li>
        </ul>
    </li>

    <li class="nav-parent"><a href=""><i class="fa fa-dot-circle-o"></i><span>ควบคุมภายใน</span></a>
        <ul class="children">
            <li><a href="basic-tables.html">Basic Tables</a></li>
            <li><a href="data-tables.html">Data Tables</a></li>
        </ul>
    </li>
    <li class="nav-parent"><a href=""><i class="fa fa-tasks"></i><span>แผนงาน</span></a>
        <ul class="children">
            <li><a href="asset-manager.html">Asset Manager</a></li>
            <li><a href="people-directory.html">People Directory</a></li>
            <li><a href="timeline.html">Timeline</a></li>
            <li><a href="profile.html">Profile</a></li>
            <li><a href="blank.html">Blank Page</a></li>
            <li><a href="notfound.html">404 Page</a></li>
            <li><a href="signin.html">Sign In</a></li>
            <li><a href="signup.html">Sign Up</a></li>
        </ul>
    </li>
    <li class="nav-parent"><a href=""><i class="fa fa-dashboard"></i><span>KPI</span></a>
        <ul class="children">
            <li><a href="asset-manager.html">Asset Manager</a></li>
            <li><a href="people-directory.html">People Directory</a></li>
            <li><a href="timeline.html">Timeline</a></li>
            <li><a href="profile.html">Profile</a></li>
            <li><a href="blank.html">Blank Page</a></li>
            <li><a href="notfound.html">404 Page</a></li>
            <li><a href="signin.html">Sign In</a></li>
            <li><a href="signup.html">Sign Up</a></li>
        </ul>
    </li>
</ul>