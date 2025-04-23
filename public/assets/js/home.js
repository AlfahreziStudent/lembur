// ketika hamburger di click
const navbarNav = document.querySelector('.sidebar');
const menu_btn = document.querySelector('.hamburger');

document.querySelector('#hamburger_home').
onclick = () => {
    navbarNav.classList.toggle('actives');
    menu_btn.classList.toggle('is-active');
};


const hamburger = document.querySelector
('#hamburger_home');

document.addEventListener('click', function(e){
    if(!hamburger.contains(e.target) && !navbarNav.contains(e.target)){
    navbarNav.classList.remove('actives');
    menu_btn.classList.remove('is-active');
    }

});

document.querySelector('#hamburger_close').
onclick = () => {
    navbarNav.classList.remove('actives');
    menu_btn.classList.remove('is-active');
};

//navbar scroll transparent
const navEl = document.querySelector('.scroll');
const navMid = document.querySelector('.scroll');
window.addEventListener('scroll', () => {
    if (window.scrollY > 300) {
        navMid.classList.add('navbar-after-scrolled');
    }else if(window.scrollY > 200) {
        navMid.classList.add('navbar-scrolled');
        navMid.classList.remove('navbar-after-scrolled');
    }else {
        navMid.classList.remove('navbar-scrolled');
    }
});
// finish navbar scroll transparent

// start pop up
const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        console.log(entry)
        if (entry.isIntersecting) {
            entry.target.classList.add('show-up');
        } else {
            entry.target.classList.remove('show-up');
        }
    });
});

const hiddenElements = document.querySelectorAll('.hidden-up');
hiddenElements.forEach((el) => observer.observe(el));
// finish pop up

// start scale
const observerScale = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        console.log(entry)
        if (entry.isIntersecting) {
            entry.target.classList.add('show-fade-in');
        } else {
            entry.target.classList.remove('show-fade-in');
        }
    });
});

const hiddenElementsScale = document.querySelectorAll('.fade-in');
hiddenElementsScale.forEach((el) => observerScale.observe(el));


//Carousel 1
// const galleryContainer = document.querySelector('.gallery-container');
// const galleryControlsContainer = document.querySelector('.gallery-controls');
// const galleryControls = ['previous', 'next'];
// const galleryItems = document.querySelectorAll('.gallery-item');

// class Carousel {
//     constructor(container, items, controls) {
//         this.carouselContainer = container;
//         this.carouselControls = controls;
//         this.carouselArray = [...items];
//         this.currentIndex = 2; // Mulai dari gambar tengah
//         this.setControls();
//         this.updateGallery();
//         this.useControls();
//     }

//     updateGallery() {
//         this.carouselArray.forEach((el, index) => {
//             el.classList.remove('gallery-item-1', 'gallery-item-2', 'gallery-item-3', 'gallery-item-4', 'gallery-item-5');
//             const itemIndex = (this.currentIndex - 2 + index + 5) % 5 + 1;
//             el.classList.add(`gallery-item-${itemIndex}`);
//         });
//     }

//     setCurrentState(direction) {
//         if (direction === 'previous') {
//             this.currentIndex = (this.currentIndex - 1 + this.carouselArray.length) % this.carouselArray.length;
//         } else {
//             this.currentIndex = (this.currentIndex + 1) % this.carouselArray.length;
//         }
//         this.updateGallery();
//     }

//     setControls() {
//         this.carouselControls.forEach(control => {
//             const button = document.createElement('button');
//             button.className = `gallery-controls-${control}`;
//             button.innerText = control;
//             galleryControlsContainer.appendChild(button);
//         });
//     }

//     useControls() {
//         this.carouselControls.forEach(control => {
//             document.querySelector(`.gallery-controls-${control}`).addEventListener('click', () => {
//                 this.setCurrentState(control);
//             });
//         });
//     }
// }
// const exampleCarousel = new Carousel(galleryContainer, galleryItems, galleryControls);

// // carousel 2
// const galleryContainer1 = document.querySelector('.gallery-container1');
// const galleryControlsContainer1 = document.querySelector('.gallery-controls1');
// const galleryControls1 = ['previous1', 'next1'];
// const galleryItems1 = document.querySelectorAll('.gallery-item1');

// class Carousel1 {
//     constructor(container, items, controls) {
//         this.carouselContainer = container;
//         this.carouselControls = controls;
//         this.carouselArray = [...items];
//         this.currentIndex = 2; // Mulai dari gambar tengah
//         this.setControls();
//         this.updateGallery();
//         this.useControls();
//     }

//     updateGallery() {
//         this.carouselArray.forEach((el, index) => {
//             el.classList.remove('gallery-item-1', 'gallery-item-2', 'gallery-item-3', 'gallery-item-4', 'gallery-item-5');
//             const itemIndex = (this.currentIndex - 2 + index + 5) % 5 + 1;
//             el.classList.add(`gallery-item-${itemIndex}`);
//         });
//     }

//     setCurrentState(direction) {
//         if (direction === 'previous1') {
//             this.currentIndex = (this.currentIndex - 1 + this.carouselArray.length) % this.carouselArray.length;
//         } else {
//             this.currentIndex = (this.currentIndex + 1) % this.carouselArray.length;
//         }
//         this.updateGallery();
//     }

//     setControls() {
//         this.carouselControls.forEach(control => {
//             const button = document.createElement('button');
//             button.className = `gallery-controls1-${control}`;
//             button.innerText = control;
//             galleryControlsContainer1.appendChild(button);
//         });
//     }

//     useControls() {
//         this.carouselControls.forEach(control => {
//             document.querySelector(`.gallery-controls1-${control}`).addEventListener('click', () => {
//                 this.setCurrentState(control);
//             });
//         });
//     }
// }

// const exampleCarousel1 = new Carousel1(galleryContainer1, galleryItems1, galleryControls1);

// // Carousel Class
// class Carousel {
//     constructor(container, items, controls, indexStart = 2) {
//         this.carouselContainer = container;
//         this.carouselControls = controls;
//         this.carouselArray = [...items];
//         this.currentIndex = indexStart; // Mulai dari gambar tengah
//         this.setControls();
//         this.updateGallery();
//         this.useControls();
//     }

//     updateGallery() {
//         const totalItems = this.carouselArray.length;
//         this.carouselArray.forEach((el, index) => {
//             el.classList.remove('gallery-item-1', 'gallery-item-2', 'gallery-item-3', 'gallery-item-4', 'gallery-item-5');
//             const itemIndex = (this.currentIndex - 2 + index + totalItems) % totalItems + 1;
//             el.classList.add(`gallery-item-${itemIndex}`);
//         });
//     }

//     setCurrentState(direction) {
//         if (direction === 'previous') {
//             this.currentIndex = (this.currentIndex - 1 + this.carouselArray.length) % this.carouselArray.length;
//         } else {
//             this.currentIndex = (this.currentIndex + 1) % this.carouselArray.length;
//         }
//         this.updateGallery();
//     }

//     // setControls() {
//     //     this.carouselControls.forEach(control => {
//     //         const button = document.createElement('button');
//     //         button.className = `${control}`;
//     //         button.innerText = control.includes('previous') ? 'Previous' : 'Next';
//     //         this.carouselContainer.parentElement.querySelector('.gallery-controls').appendChild(button);
//     //     });
//     // }

//     setControls() {
//         this.carouselControls.forEach(control => {
//             const button = document.createElement('button');
//             button.className = `gallery-controls-${control}`;
//             button.innerText = ''; // Kosongkan teks agar panah dapat tampil
//             this.carouselContainer.parentElement.querySelector('.gallery-controls').appendChild(button);
//         });
//     }

//     useControls() {
//         this.carouselControls.forEach(control => {
//             this.carouselContainer.parentElement.querySelector(`.${control}`).addEventListener('click', () => {
//                 this.setCurrentState(control);
//             });
//         });
//     }
// }

// // Menginisialisasi Lima Carousel dengan ID/Kelas Unik
// const galleryContainers = [
//     document.querySelector('.gallery-container1'),
//     document.querySelector('.gallery-container2'),
//     document.querySelector('.gallery-container3'),
//     document.querySelector('.gallery-container4'),
//     document.querySelector('.gallery-container5'),
//     document.querySelector('.gallery-container6'),
//     document.querySelector('.gallery-container7')
// ];

// const galleryControls = [
//     ['previous1', 'next1'],
//     ['previous2', 'next2'],
//     ['previous3', 'next3'],
//     ['previous4', 'next4'],
//     ['previous5', 'next5'],
//     ['previous6', 'next6'],
//     ['previous7', 'next7']
// ];

// const galleryItems = [
//     document.querySelectorAll('.gallery-item1'),
//     document.querySelectorAll('.gallery-item2'),
//     document.querySelectorAll('.gallery-item3'),
//     document.querySelectorAll('.gallery-item4'),
//     document.querySelectorAll('.gallery-item5'),
//     document.querySelectorAll('.gallery-item6'),
//     document.querySelectorAll('.gallery-item7')
// ];

// // Membuat Instance untuk Setiap Carousel
// const carousels = galleryContainers.map((container, index) => {
//     return new Carousel(container, galleryItems[index], galleryControls[index]);
// });

// Carousel Class
class Carousel {
    constructor(container, items, controls, indexStart = 2) {
        this.carouselContainer = container;
        this.carouselControls = controls;
        this.carouselArray = [...items];
        this.currentIndex = indexStart; // Mulai dari gambar tengah
        this.setControls();
        this.updateGallery();
        this.useControls();
    }

    updateGallery() {
        const totalItems = this.carouselArray.length;
        this.carouselArray.forEach((el, index) => {
            el.classList.remove('gallery-item-1', 'gallery-item-2', 'gallery-item-3', 'gallery-item-4', 'gallery-item-5');
            const itemIndex = (this.currentIndex - 2 + index + totalItems) % totalItems + 1;
            el.classList.add(`gallery-item-${itemIndex}`);
        });
    }

    setCurrentState(direction) {
        if (direction === 'previous') {
            this.currentIndex = (this.currentIndex - 1 + this.carouselArray.length) % this.carouselArray.length;
        } else {
            this.currentIndex = (this.currentIndex + 1) % this.carouselArray.length;
        }
        this.updateGallery();
    }

    setControls() {
        const controlsContainer = this.carouselContainer.parentElement.querySelector('.gallery-controls');
        this.carouselControls.forEach(control => {
            const button = document.createElement('button');
            button.className = `gallery-controls-${control}`;
            button.innerText = ''; // Kosongkan teks agar panah dapat tampil
            controlsContainer.appendChild(button);
        });
    }

    useControls() {
        this.carouselControls.forEach(control => {
            this.carouselContainer.parentElement.querySelector(`.gallery-controls-${control}`).addEventListener('click', () => {
                this.setCurrentState(control.replace(/[0-9]/g, '')); // Menghapus angka agar sesuai dengan "previous" atau "next"
            });
        });
    }
}

// Menginisialisasi Lima Carousel dengan ID/Kelas Unik
const galleryContainers = [
    document.querySelector('.gallery-container1'),
    document.querySelector('.gallery-container2'),
    document.querySelector('.gallery-container3'),
    document.querySelector('.gallery-container4'),
    document.querySelector('.gallery-container5'),
    document.querySelector('.gallery-container6'),
    document.querySelector('.gallery-container7')
];

const galleryControls = [
    ['previous1', 'next1'],
    ['previous2', 'next2'],
    ['previous3', 'next3'],
    ['previous4', 'next4'],
    ['previous5', 'next5'],
    ['previous6', 'next6'],
    ['previous7', 'next7']
];

const galleryItems = [
    document.querySelectorAll('.gallery-item1'),
    document.querySelectorAll('.gallery-item2'),
    document.querySelectorAll('.gallery-item3'),
    document.querySelectorAll('.gallery-item4'),
    document.querySelectorAll('.gallery-item5'),
    document.querySelectorAll('.gallery-item6'),
    document.querySelectorAll('.gallery-item7')
];

// Membuat Instance untuk Setiap Carousel
const carousels = galleryContainers.map((container, index) => {
    return new Carousel(container, galleryItems[index], galleryControls[index]);
});

