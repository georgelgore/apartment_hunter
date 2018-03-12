$(document).ready(function() {
  var data;
  $.ajax({
    dataType: "json",
    url: "http://localhost:8080/apartmenthunt/php/export.php",
    data: data,
    success: function(data) {
      // console.log(data);
      for (let x = 0; x < data.length; x++) {
        document.querySelector("tbody.list").innerHTML += `<tr>
            <td> ${data[x].apartmentname} </td>
            <td> ${data[x].beds} </td>
            <td> ${data[x].baths} </td>
            <td> ${data[x].floorplanname} </td>
            <td> $${parseInt(data[x].rentlow).toLocaleString()} - $${parseInt(
          data[x].renthigh
        ).toLocaleString()}</td>
          <td> <a target="_blank" href=${data[x].applylink}>Link</a></td>
          </tr>`;
      }
    }
  });
});
