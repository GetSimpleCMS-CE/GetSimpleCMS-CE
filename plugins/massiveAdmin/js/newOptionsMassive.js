
const foldericon = `
<svg xmlns="http://www.w3.org/2000/svg" style="display:inline-block;width:15px;" viewBox="0 0 24 24" id="folder"><path d="M19,5.5H12.72l-.32-1a3,3,0,0,0-2.84-2H5a3,3,0,0,0-3,3v13a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V8.5A3,3,0,0,0,19,5.5Zm1,13a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V5.5a1,1,0,0,1,1-1H9.56a1,1,0,0,1,.95.68l.54,1.64A1,1,0,0,0,12,7.5h7a1,1,0,0,1,1,1Z"></path></svg>`;

const foldericon2 = `
<svg xmlns="http://www.w3.org/2000/svg" style="display:inline-block;width:50px;" viewBox="0 0 24 24" id="folder"><path fill="#fff" d="M19,5.5H12.72l-.32-1a3,3,0,0,0-2.84-2H5a3,3,0,0,0-3,3v13a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V8.5A3,3,0,0,0,19,5.5Zm1,13a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V5.5a1,1,0,0,1,1-1H9.56a1,1,0,0,1,.95.68l.54,1.64A1,1,0,0,0,12,7.5h7a1,1,0,0,1,1,1Z"></path></svg>`;
 
const copyicon = `
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="display:inline-block;width:15px;" id="copy"><path  d="M21,8.94a1.31,1.31,0,0,0-.06-.27l0-.09a1.07,1.07,0,0,0-.19-.28h0l-6-6h0a1.07,1.07,0,0,0-.28-.19.32.32,0,0,0-.09,0A.88.88,0,0,0,14.05,2H10A3,3,0,0,0,7,5V6H6A3,3,0,0,0,3,9V19a3,3,0,0,0,3,3h8a3,3,0,0,0,3-3V18h1a3,3,0,0,0,3-3V9S21,9,21,8.94ZM15,5.41,17.59,8H16a1,1,0,0,1-1-1ZM15,19a1,1,0,0,1-1,1H6a1,1,0,0,1-1-1V9A1,1,0,0,1,6,8H7v7a3,3,0,0,0,3,3h5Zm4-4a1,1,0,0,1-1,1H10a1,1,0,0,1-1-1V5a1,1,0,0,1,1-1h3V7a3,3,0,0,0,3,3h3Z"></path></svg>`;

const downloadicon = `
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="display:inline-block;width:15px;"  id="file-download"><path  d="M20,8.94a1.31,1.31,0,0,0-.06-.27l0-.09a1.07,1.07,0,0,0-.19-.28h0l-6-6h0a1.07,1.07,0,0,0-.28-.19l-.1,0A1.1,1.1,0,0,0,13.06,2H7A3,3,0,0,0,4,5V19a3,3,0,0,0,3,3H17a3,3,0,0,0,3-3V9S20,9,20,8.94ZM14,5.41,16.59,8H15a1,1,0,0,1-1-1ZM18,19a1,1,0,0,1-1,1H7a1,1,0,0,1-1-1V5A1,1,0,0,1,7,4h5V7a3,3,0,0,0,3,3h3Zm-4.71-4.71-.29.3V12a1,1,0,0,0-2,0v2.59l-.29-.3a1,1,0,0,0-1.42,1.42l2,2a1,1,0,0,0,.33.21.94.94,0,0,0,.76,0,1,1,0,0,0,.33-.21l2-2a1,1,0,0,0-1.42-1.42Z"></path></svg>`;

const closeicon = `
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="times"><path d="M13.41,12l4.3-4.29a1,1,0,1,0-1.42-1.42L12,10.59,7.71,6.29A1,1,0,0,0,6.29,7.71L10.59,12l-4.3,4.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l4.29,4.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path></svg>`;




if (window.location.href.indexOf('?type=carousel') < 0) {

    window.onload = function () {
        const imageTableTd = document.querySelectorAll('#imageTable .All');



        imageTableTd.forEach(e => {
            if (e.querySelector('.imgthumb img') !== null) {
                const name = e.querySelector('#imageTable .All .imgthumb img').getAttribute('src');
                console.log(name);



                if (e.querySelector('.delete .delconfirm') !== null) {

                    const deleteBtn = e.querySelector('.delete .delconfirm');
                    const renameBtn = document.createElement('button');
                    renameBtn.classList.add('rename-massive-btn');
                    renameBtn.innerHTML = foldericon;
                    deleteBtn.insertAdjacentElement('afterend', renameBtn);

                    const copyBtn = document.createElement('button');
                    copyBtn.classList.add('copy-massive-btn');
                    copyBtn.innerHTML = copyicon;
                    deleteBtn.insertAdjacentElement('afterend', copyBtn);

                    const downloadBtn = document.createElement('a');
                    downloadBtn.classList.add('download-massive-btn');
                    downloadBtn.setAttribute('href', name);
                    downloadBtn.setAttribute('download', name);
                    downloadBtn.innerHTML = downloadicon;
                    deleteBtn.insertAdjacentElement('afterend', downloadBtn);


                    renameBtn.addEventListener('click', () => {
                        document.querySelector('.rename-fog').classList.remove('hide-fog');
                        document.querySelector('input[name="rename-massive-hide"]').value = name.substr('16');
                        document.querySelector('input[name="rename-massive"]').value = name.substr('16');
                        document.querySelector('input[name="save-rename-massive"]').style.display = "block";
                        document.querySelector('input[name="copy-rename-massive"]').style.display = "none";
                    });

                    copyBtn.addEventListener('click', () => {
                        document.querySelector('.rename-fog').classList.remove('hide-fog');
                        document.querySelector('input[name="rename-massive-hide"]').value = name.substr('16');
                        document.querySelector('input[name="rename-massive"]').value = name.substr('16');
                        document.querySelector('input[name="save-rename-massive"]').style.display = "none";
                        document.querySelector('input[name="copy-rename-massive"]').style.display = "block";
                    });



                };
            }
        });



        const closeRename = document.querySelector('.close-rename-fog');

        closeRename.addEventListener('click', (e) => {
            e.preventDefault();
            document.querySelector('.rename-fog').classList.add('hide-fog');


        });


    };




    if (document.querySelector('.All.folder') !== null) {

        document.querySelectorAll('.All.folder').forEach(e => {

            const linker = e.querySelector('a').getAttribute('href');
            e.querySelector('img').insertAdjacentHTML('beforebegin', '<a href="' + linker + '" class="massive-folder-linker">'+foldericon2+'</a>');

            e.querySelector('img').remove();
            e.querySelector('.imgthumb').remove();



        });
    };



};

document.querySelectorAll('.imgthumb').forEach(x => {
    if (x.innerHTML == '') {
        x.innerHTML = `<div class="massive-folder-linker">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="file" style="display:inline-block;width:50px;"><path fill="#fff" d="M20,8.94a1.31,1.31,0,0,0-.06-.27l0-.09a1.07,1.07,0,0,0-.19-.28h0l-6-6h0a1.07,1.07,0,0,0-.28-.19l-.09,0L13.06,2H7A3,3,0,0,0,4,5V19a3,3,0,0,0,3,3H17a3,3,0,0,0,3-3V9S20,9,20,8.94ZM14,5.41,16.59,8H14ZM18,19a1,1,0,0,1-1,1H7a1,1,0,0,1-1-1V5A1,1,0,0,1,7,4h5V9a1,1,0,0,0,1,1h5Z"></path></svg>
        </div>`;
    }
});

document.querySelectorAll('.all').forEach(c => {

    if (c.querySelector('.primarylink img') !== null) {
        c.querySelector('.primarylink img').style.display = "none";
    }


})


 
 