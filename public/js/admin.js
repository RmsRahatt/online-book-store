function validateBookForm() {
  let valid = true;

  let title = document.getElementById("title").value.trim();
  if (title == "") {
    document.getElementById("titleError").innerHTML = "Title is required!";
    valid = false;
  } else {
    document.getElementById("titleError").innerHTML = "";
  }

  let author = document.getElementById("author").value.trim();
  if (author == "") {
    document.getElementById("authorError").innerHTML = "Author is required!";
    valid = false;
  } else {
    document.getElementById("authorError").innerHTML = "";
  }

  let desc = document.getElementById("description").value.trim();
  if (desc == "") {
    document.getElementById("descError").innerHTML = "Description is required!";
    valid = false;
  } else {
    document.getElementById("descError").innerHTML = "";
  }

  let price = parseFloat(document.getElementById("price").value);
  if (isNaN(price) || price <= 0) {
    document.getElementById("priceError").innerHTML =
      "Valid price is required!";
    valid = false;
  } else {
    document.getElementById("priceError").innerHTML = "";
  }

  let cat = document.getElementById("category_id").value;
  if (cat == "") {
    document.getElementById("catError").innerHTML = "Please select a category!";
    valid = false;
  } else {
    document.getElementById("catError").innerHTML = "";
  }

  let stock = parseInt(document.getElementById("stock").value);
  if (isNaN(stock) || stock < 0) {
    document.getElementById("stockError").innerHTML =
      "Valid stock amount is required!";
    valid = false;
  } else {
    document.getElementById("stockError").innerHTML = "";
  }

  let imgInput = document.getElementById("image");
  if (imgInput && imgInput.files.length > 0) {
    let file = imgInput.files[0];
    let allowed = ["image/jpeg", "image/png"];
    if (!allowed.includes(file.type) || file.size > 2 * 1024 * 1024) {
      document.getElementById("imageError").innerHTML =
        "Only JPG/PNG under 2MB allowed!";
      valid = false;
    } else {
      document.getElementById("imageError").innerHTML = "";
    }
  }

  return valid;
}

function deleteCustomer(id) {
  if (
    !confirm(
      "Delete this customer? Their cart and orders will also be removed.",
    )
  ) {
    return;
  }

  let xhttp = new XMLHttpRequest();
  xhttp.open("post", "../../controller/customerDelete.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("id=" + id);

  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let res = JSON.parse(this.responseText);
      if (res.success) {
        let row = document.getElementById("row_" + id);
        if (row) {
          row.remove();
        }
        let msg = document.getElementById("flashMsg");
        msg.innerHTML = res.message;

        setTimeout(function () {
          msg.innerHTML = "";
        }, 3000);
      } else {
        alert("Error: " + res.message);
      }
    }
  };
}

function updateOrderStatus(orderId, status) {
  let xhttp = new XMLHttpRequest();
  xhttp.open("post", "../../controller/orderStatusUpdate.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("order_id=" + orderId + "&status=" + status);

  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let res = JSON.parse(this.responseText);
      if (res.success) {
        let badge = document.getElementById("badge_" + orderId);
        badge.className = "badge badge-" + status;
        badge.innerHTML = status.charAt(0).toUpperCase() + status.slice(1);

        let select = document.getElementById("select_" + orderId);
        if (select) {
          select.value = status;
        }

        let msg = document.getElementById("flashMsg");
        msg.innerHTML = res.message;

        setTimeout(function () {
          msg.innerHTML = "";
        }, 3000);
      } else {
        alert("Error: " + res.message);
      }
    }
  };
}
