document.querySelectorAll('.remove').forEach(function(r) {
  r.onclick = async function() {
    var id = r.parentNode.parentNode.getElementsByClassName("id")[0].innerText;

    if (r.innerText == "Delete") {
      await fetch(`/admin/productlist/delete.php?id=${id}`);
      window.location.reload(true);
    } else {
      window.location.href = `/admin/productlist/edit.php?id=${id}`
    }

  };
});
