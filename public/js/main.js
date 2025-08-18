// import "../../resources/css/app.css";

// Top-End Flasher SweetAlert2
document.addEventListener('livewire:init', () => {
    Livewire.on('swal-toast', () => {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            icon: event.detail.icon,
            title: event.detail.title
        });
    });
});

// Student Profile
// Line Graph
var options = {
  series: [
    {
      name: "series1",
      data: [31, 40, 28, 51, 42, 109, 100],
    },
    {
      name: "series2",
      data: [11, 32, 45, 32, 34, 52, 41],
    },
  ],
  chart: {
    height: 350,
    type: "area",
  },
  dataLabels: {
    enabled: false,
  },
  stroke: {
    curve: "smooth",
  },
  xaxis: {
    type: "datetime",
    categories: [
      "2018-09-19T00:00:00.000Z",
      "2018-09-19T01:30:00.000Z",
      "2018-09-19T02:30:00.000Z",
      "2018-09-19T03:30:00.000Z",
      "2018-09-19T04:30:00.000Z",
      "2018-09-19T05:30:00.000Z",
      "2018-09-19T06:30:00.000Z",
    ],
  },
  tooltip: {
    x: {
      format: "dd/MM/yy HH:mm",
    },
  },
};

var chart = new ApexCharts(
  document.querySelector("#PerformanceLinechart"),
  options
);
chart.render();

// Barchart
var options = {
  series: [
    {
      name: "Net Profit",
      data: [44, 55, 57, 56, 61, 58, 63, 60, 66],
    },
    {
      name: "Revenue",
      data: [76, 85, 101, 98, 87, 105, 91, 114, 94],
    },
    {
      name: "Free Cash Flow",
      data: [35, 41, 36, 26, 45, 48, 52, 53, 41],
    },
  ],
  chart: {
    type: "bar",
    height: 350,
  },
  plotOptions: {
    bar: {
      horizontal: false,
      columnWidth: "55%",
      borderRadius: 5,
      borderRadiusApplication: "end",
    },
  },
  dataLabels: {
    enabled: false,
  },
  stroke: {
    show: true,
    width: 2,
    colors: ["transparent"],
  },
  xaxis: {
    categories: ["Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct"],
  },
  yaxis: {
    title: {
      text: "$ (thousands)",
    },
  },
  fill: {
    opacity: 1,
  },
  tooltip: {
    y: {
      formatter: function (val) {
        return "$ " + val + " thousands";
      },
    },
  },
};

var chart = new ApexCharts(
  document.querySelector("#PerformanceBarchart"),
  options
);
chart.render();
// End of Student Performance

// Wait for DOM
window.addEventListener("DOMContentLoaded", () => {
  // Elements
  const addTeacherBtn = document.getElementById("addTeacherBtn");
  const teacherFormPopup = document.getElementById("teacherFormPopup");
  const cancelBtn = document.getElementById("cancelBtn");
  const nextBtn = document.getElementById("nextBtn");
  const prevBtn = document.getElementById("prevBtn");
  const submitBtn = document.getElementById("submitBtn");
  const cancelSecondBtn = document.getElementById("cancelSecondBtn");
  const firstForm = document.getElementById("firstForm");
  const secondForm = document.getElementById("secondForm");

  const successPopup = document.getElementById("successPopup");
  const closeSuccessBtn = document.getElementById("closeSuccessBtn");
  const popupPhoto = document.getElementById("popupPhoto");
  const popupName = document.getElementById("popupName");
  const popupLicense = document.getElementById("popupLicense");

  const profileInput = document.getElementById("profileInput");
  const profilePreview = document.getElementById("profilePreview");

  // Image preview on upload
  profileInput.addEventListener("change", function () {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        profilePreview.src = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  });

  // Open form popup
  addTeacherBtn.addEventListener("click", () => {
    teacherFormPopup.classList.remove("hidden");
    firstForm.classList.remove("hidden");
    secondForm.classList.add("hidden");
  });

  // Cancel from first form
  cancelBtn.addEventListener("click", () => {
    teacherFormPopup.classList.add("hidden");
    firstForm.classList.remove("hidden");
    secondForm.classList.add("hidden");
  });

  // Cancel from second form
  cancelSecondBtn.addEventListener("click", () => {
    teacherFormPopup.classList.add("hidden");
    firstForm.classList.remove("hidden");
    secondForm.classList.add("hidden");
  });

  // Click outside popup closes form
  teacherFormPopup.addEventListener("click", (e) => {
    if (e.target === teacherFormPopup) {
      teacherFormPopup.classList.add("hidden");
      firstForm.classList.remove("hidden");
      secondForm.classList.add("hidden");
    }
  });

  // Go to second form
  nextBtn.addEventListener("click", () => {
    firstForm.classList.add("hidden");
    secondForm.classList.remove("hidden");
  });

  // Go back to first form
  prevBtn.addEventListener("click", () => {
    secondForm.classList.add("hidden");
    firstForm.classList.remove("hidden");
  });

  // Final Submit
  submitBtn.addEventListener("click", (e) => {
    e.preventDefault();

    // Collect values
    const license = firstForm.querySelector(
      "input[placeholder='License Number']"
    ).value;
    const firstName = firstForm.querySelector(
      "input[placeholder='First name']"
    ).value;
    const middleName = firstForm.querySelector(
      "input[placeholder='Middle name']"
    ).value;
    const lastName = firstForm.querySelector(
      "input[placeholder='Last name']"
    ).value;
    const profileSrc = profilePreview.src;

    // Populate popup
    popupPhoto.src = profileSrc;
    popupName.textContent = `${firstName} ${middleName} ${lastName}`.trim();
    popupLicense.textContent = `License No: ${license}`;

    // Show popup
    teacherFormPopup.classList.add("hidden");
    successPopup.classList.remove("hidden");

    // Reset to first form view
    firstForm.classList.remove("hidden");
    secondForm.classList.add("hidden");
  });

  closeSuccessBtn.addEventListener("click", () => {
    successPopup.classList.add("hidden");
  });
});
// Photo upload

document
  .getElementById("profileInput")
  .addEventListener("change", function (e) {
    const file = e.target.files[0];
    const preview = document.getElementById("profilePreview");

    if (file) {
      const reader = new FileReader();
      reader.onload = function (event) {
        preview.src = event.target.result;
      };
      reader.readAsDataURL(file);
    }
  });

const barangayData = {
  Boac: [
    "Agot",
    "Agumaymayan",
    "Apitong",
    "Balagasan",
    "Balaring",
    "Balimbing",
    "Bangbang",
    "Bantad",
    "Bayanan",
    "Binunga",
    "Boi",
    "Boton",
    "Caganhao",
    "Canat",
    "Catubugan",
    "Cawit",
    "Daig",
    "Duyay",
    "Hinapulan",
    "Ibaba",
    "Isok I",
    "Isok II",
    "Laylay",
    "Libtangin",
    "Lupac",
    "Mahinhin",
    "Malbog",
    "Malindig",
    "Maligaya",
    "Mansiwat",
    "Mercado",
    "Murallon",
    "Pawa",
    "Poras",
    "Pulang Lupa",
    "Puting Buhangin",
    "San Miguel",
    "Tabi",
    "Tabigue",
    "Tampus",
    "Tambunan",
    "Tugos",
    "Tumalum",
  ],
  Mogpog: [
    "Bintakay",
    "Bocboc",
    "Butansapa",
    "Candahon",
    "Capayang",
    "Danao",
    "Dulong Bayan",
    "Gitnang Bayan",
    "Hinadharan",
    "Hinanggayon",
    "Ino",
    "Janagdong",
    "Malayak",
    "Mampaitan",
    "Market Site",
    "Nangka I",
    "Nangka II",
    "Silangan",
    "Sumangga",
    "Tabi",
    "Tarug",
    "Villa Mendez",
  ],
  Gasan: [
    "Antipolo",
    "Bachao Ibaba",
    "Bachao Ilaya",
    "Bacong-Bacong",
    "Bahi",
    "Banot",
    "Banuyo",
    "Cabugao",
    "Dawis",
    "Ipil",
    "Mangili",
    "Masiga",
    "Mataas na Bayan",
    "Pangi",
    "Pinggan",
    "Tabionan",
    "Tiguion",
  ],
  Buenavista: [
    "Bagacay",
    "Bagtingon",
    "Bicas-Bicas",
    "Caigangan",
    "Daykitin",
    "Libas",
    "Malbog",
    "Sihi",
    "Timbo",
    "Tungib-Lipata",
    "Yook",
  ],
  Torrijos: [
    "Bangwayin",
    "Bayakbakin",
    "Bolo",
    "Buangan",
    "Cagpo",
    "Dampulan",
    "Kay Duke",
    "Macawayan",
    "Malibago",
    "Malinao",
    "Marlangga",
    "Matuyatuya",
    "Poblacion",
    "Poctoy",
    "Sibuyao",
    "Suha",
    "Talawan",
    "Tigwi",
  ],
  "Santa Cruz": [
    "Alobo",
    "Angas",
    "Aturan",
    "Baguidbirin",
    "Banahaw",
    "Bangcuangan",
    "Biga",
    "Bolo",
    "Bonliw",
    "Botilao",
    "Buyabod",
    "Dating Bayan",
    "Devilla",
    "Dolores",
    "Haguimit",
    "Ipil",
    "Jolo",
    "Kaganhao",
    "Kalangkang",
    "Kasily",
    "Kilo-kilo",
    "Kinyaman",
    "Lamesa",
    "Lapu-lapu",
    "Lipata",
    "Lusok",
    "Maharlika",
    "Maniwaya",
    "Masaguisi",
    "Matalaba",
    "Mongpong",
    "Pantayin",
    "Pili",
    "Poblacion",
    "Punong",
    "San Antonio",
    "Tagum",
    "Tamayo",
    "Tawiran",
    "Taytay",
  ],
};
function populateBarangays(muniId, datalistId) {
  const muni = document.getElementById(muniId).value;
  const datalist = document.getElementById(datalistId);
  datalist.innerHTML = ""; // Clear existing options

  if (barangayData[muni]) {
    barangayData[muni].forEach((brgy) => {
      const option = document.createElement("option");
      option.value = brgy;
      datalist.appendChild(option);
    });
  }
}

document.addEventListener("DOMContentLoaded", () => {
  document.getElementById("perm-muni").addEventListener("change", () => {
    populateBarangays("perm-muni", "perm-brgy-list");
  });

  document.getElementById("curr-muni").addEventListener("change", () => {
    populateBarangays("curr-muni", "curr-brgy-list");
  });
});
