<?php
if($row['category']==1)
{
    $category = "Shopkeeper";
}
else{
    $category = "Customer";
}
if(!($row['category'] == 2))
{
 ?>
<tr id="row-<?php echo $row['pkci_user_ajaxid']; ?>">
    <td class="modelName"><?php echo $row['name']; ?></td>
    <td class="modelEmail"><?php echo $row['email']; ?></td>
    <td class="modelCategory"><?php echo $category; ?></td>
    <td ><a href="javascript:void(0)" onclick="showEditForm(<?php echo $row['pkci_user_ajaxid']; ?>)" class='edit btn btn-sm btn-primary' >Edit</a>
         <a href="javascript:void(0)" onclick="confirmMsg(<?php echo $row['pkci_user_ajaxid']; ?>)" class='delete btn btn-sm btn-danger' >Delete</a></td>
</tr>
<?php
}