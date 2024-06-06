// $(document).ready(function () {
//   const galleryContainer = $("#gallery-container");

//   // URL JSON online
//   const jsonUrl = "https://json.link/hdoFmSGDrd.json";

//   $.getJSON(jsonUrl, function (data) {
//     data.images.forEach((image) => {
//       const cardElement = `
//         <div class="col-md-4 mb-4">
//           <div class="card">
//             <img src="${image.url}" class="card-img-top" alt="${image.alt}">
//             <div class="card-body">
//               <p class="card-text">${image.caption}</p>
//             </div>
//           </div>
//         </div>
//       `;
//       galleryContainer.append(cardElement);
//     });
//   });
// });
