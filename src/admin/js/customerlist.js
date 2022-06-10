document.querySelectorAll('.remove').forEach(function(r) {
  r.onclick = async function() {
    var email = r.parentNode.parentNode.getElementsByClassName("email")[0].innerText;

    if (r.innerText == "Delete") {
      await fetch(`/admin/customerlist/delete.php?email=${email}`);
      window.location.reload(true);
    } else {
      window.location.href = `/admin/customerlist/edit.php?email=${email}`
    }

  };
});
