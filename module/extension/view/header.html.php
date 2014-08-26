<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/tablesorter.html.php';?>
<div id='featurebar'>
  <ul class='nav'>
  <?php 
  echo '<li id="installed">'; common::printLink('extension', 'browse', "type=installed",   $lang->extension->installed); echo '</li>';
  echo '<li id="deactivated">'; common::printLink('extension', 'browse', "type=deactivated", $lang->extension->deactivated); echo '</li>';
  echo '<li id="available">'; common::printLink('extension', 'browse', "type=available",   $lang->extension->available ); echo '</li>';
  echo '<li>'; common::printLink('extension', 'upload', '', $lang->extension->upload, '', "class='iframe'"); echo '</li>';
  echo "<li id='editor'>"; common::printLink('editor', 'index', 'type=editor', $lang->editor->common . '&' . $lang->editor->api); echo '</li>';
?>
  </ul>
  <div class='actions'>
    <div class='btn-group'><?php common::printLink('extension', 'obtain', '', $lang->extension->obtain, '', "class='btn'");?></div>
  </div>
</div>
<script>$('#<?php echo $tab;?>').addClass('active')</script>
