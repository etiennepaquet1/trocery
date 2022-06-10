document.querySelectorAll('.remove').forEach(function(r) {
  r.onclick = async function() {
    var id = r.parentNode.parentNode.getElementsByClassName("id")[0].innerText;

    if (r.innerText == "Delete") {
      await fetch(`/admin/orderlist/delete.php?id=${id}`);
      window.location.reload(true);
    } else {
      window.location.href = `/admin/orderlist/edit.php?id=${id}`
    }

  };
});
