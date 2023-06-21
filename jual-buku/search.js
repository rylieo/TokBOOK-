document.getElementById("search-input").oninput = function searchPost() {
    // Declare variables
    var input, filter, li, tampung, a, i, txtValue;
    input = document.getElementById('search-input');
    filter = input.value.toUpperCase();
    li = document.getElementsByClassName('buku');
    tampung = [];

    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("p")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
        li[i].style.display = "";
        } else {
        li[i].style.display = "none";
        tampung.push(i);
        }
    }

    if (tampung.length === li.length) {
        if (!document.getElementById('nofound')) {
            var hm = document.getElementsByClassName("search-article");
            hm[0].insertAdjacentHTML('afterend', `<div style="font-size: large;font-weight: 600;" id="nofound"><p id="nfmsg"></p></div>`);
        }
        if (document.getElementById('nofound')) {
            document.getElementById('nfmsg').innerText = `Sorry, nothing matched with "${input.value}"`;
        }
    } else {
        if (document.getElementById('nofound')) {
            document.getElementById("nofound").remove();
        }
    }
}