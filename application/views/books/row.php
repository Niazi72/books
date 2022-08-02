<tr id="row-<?php echo $row['pkci_book_ajaxid']; ?>">
    <td class="modelTitle"><?php echo $row['title']; ?></td>
    <td class="modelPublishby"><?php echo $row['publishby']; ?></td>
    <td class="modelImage"><img id="imageid" width='50' height='50' src="<?php echo base_url().'uploads/'.$row['image']; ?>"/></td>
    <td class="modelDescription"><?php echo $row['description']; ?></td>
    <?php if ($this->session->userdata('category')== '2') { ?>
    <td ><a href="javascript:void(0)" onclick="showEditForm(<?php echo $row['pkci_book_ajaxid']; ?>)" class='edit btn btn-sm btn-primary' >Edit</a>
        <a href="javascript:void(0)" onclick="confirmMsg(<?php echo $row['pkci_book_ajaxid']; ?>)" class='delete btn btn-sm btn-danger' >Delete</a></td>
        <?php } elseif($this->session->userdata('category')== '1'){?>
            <td ><a href="javascript:void(0)" onclick="showEditForm(<?php echo $row['pkci_book_ajaxid']; ?>)" class='edit btn btn-sm btn-primary' >Edit</a></td>
        <?php }?>
</tr>