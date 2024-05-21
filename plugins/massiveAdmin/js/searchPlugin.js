window.addEventListener("load", function () {
    if (document.querySelector('body#plugins') !== null) {
        const powerIcon = `
        <svg xmlns="http://www.w3.org/2000/svg" style="display:inline-block;width:15px;height:15px;color:#fff;fill:#fff;" viewBox="0 0 24 24" id="power"><path d="M10.21,6.21l.79-.8V10a1,1,0,0,0,2,0V5.41l.79.8a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42l-2.5-2.5a1,1,0,0,0-.33-.21,1,1,0,0,0-.76,0,1,1,0,0,0-.33.21l-2.5,2.5a1,1,0,0,0,1.42,1.42ZM18,7.56A1,1,0,1,0,16.56,9,6.45,6.45,0,1,1,7.44,9,1,1,0,1,0,6,7.56a8.46,8.46,0,1,0,12,0Z"></path></svg>`;

        document.querySelector('.highlight').insertAdjacentHTML('beforebegin', '<div class="searchoption"></div>');

        const searchdiv = document.querySelector('.searchoption');
        searchdiv.style.margin = "10px 0";
        searchdiv.insertAdjacentHTML('afterbegin', '<input type="text" class="pluginsfind" style="padding:8px;width:85%" placeholder="find plugin">');
        searchdiv.insertAdjacentHTML('afterbegin', '<button class="plugin-on" style="cursor:pointer;background:green;color:#fff;padding:8px;margin-right:10px;border:none;border-radius:2px;">'+powerIcon+'</button>');
        searchdiv.insertAdjacentHTML('afterbegin', '<button class="plugin-off" style="cursor:pointer;background:red;color:#fff;padding:8px;margin-right:10px;border:none;border-radius:2px;">'+powerIcon+'</button>');
        searchdiv.insertAdjacentHTML('afterbegin', '<button class="plugin-all" style="cursor:pointer;background:grey;color:#fff;padding:8px;margin-right:10px;border:none;border-radius:2px;">'+powerIcon+'</button>');

        document.querySelector('.plugin-all').addEventListener('click', () => {
            document.querySelectorAll('.enabled').forEach(x => {
                x.style.display = "flex"
            });
            document.querySelectorAll('.disabled').forEach(z => {
                z.style.display = "flex"
            });
        });

        document.querySelector('.plugin-on').addEventListener('click', () => {
            document.querySelectorAll('.enabled').forEach(x => {
                x.style.display = "flex"
            });
            document.querySelectorAll('.disabled').forEach(z => {
                z.style.display = "none"
            });
        });

        document.querySelector('.plugin-off').addEventListener('click', () => {
            document.querySelectorAll('.disabled').forEach(x => {
                x.style.display = "flex"
            });
            document.querySelectorAll('.enabled').forEach(z => {
                z.style.display = "none"
            });
        });

        //searchform
        const input = document.querySelector('.pluginsfind');

        input.addEventListener("keyup", e => {
            console.log(input.value);
            document.querySelectorAll('.highlight tr').forEach(c => {
                if (c.querySelector('td') !== null) {
                    const names = c.querySelector('td').innerText;
                    const newnames = names.toLowerCase();
                    if (newnames.includes(input.value)) {
                        c.style.display = "flex";
                    } else {
                        c.style.display = "none";
                    };
                    if (input.value == "") {
                        c.style.display = "flex";
                    }
                };
            });
        });
    };
});