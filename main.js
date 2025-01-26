$(document).ready(function ($) {
    "use strict";


    var book_table = new Swiper(".book-table-img-slider", {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        speed: 2000,
        effect: "coverflow",
        coverflowEffect: {
            rotate: 3,
            stretch: 2,
            depth: 100,
            modifier: 5,
            slideShadows: false,
        },
        loopAdditionSlides: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });

    var team_slider = new Swiper(".team-slider", {
        slidesPerView: 3,
        spaceBetween: 30,
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        speed: 2000,

        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            0: {
                slidesPerView: 1.2,
            },
            768: {
                slidesPerView: 2,
            },
            992: {
                slidesPerView: 3,
            },
            1200: {
                slidesPerView: 3,
            },
        },
    });

    jQuery(".filters").on("click", function () {
        jQuery("#menu-dish").removeClass("bydefault_show");
    });
    $(function () {
        var filterList = {
            init: function () {
                $("#menu-dish").mixItUp({
                    selectors: {
                        target: ".dish-box-wp",
                        filter: ".filter",
                    },
                    animation: {
                        effects: "fade",
                        easing: "ease-in-out",
                    },
                    load: {
                        filter: ".all, .breakfast, .lunch, .dinner",
                    },
                });
            },
        };
        filterList.init();
    });

    jQuery(".menu-toggle").click(function () {
        jQuery(".main-navigation").toggleClass("toggled");
    });

    jQuery(".header-menu ul li a").click(function () {
        jQuery(".main-navigation").removeClass("toggled");
    });

    gsap.registerPlugin(ScrollTrigger);

    var elementFirst = document.querySelector('.site-header');
    ScrollTrigger.create({
        trigger: "body",
        start: "30px top",
        end: "bottom bottom",

        onEnter: () => myFunction(),
        onLeaveBack: () => myFunction(),
    });

    function myFunction() {
        elementFirst.classList.toggle('sticky_head');
    }

    var scene = $(".js-parallax-scene").get(0);
    var parallaxInstance = new Parallax(scene);


});


jQuery(window).on('load', function () {
    $('body').removeClass('body-fixed');

    //activating tab of filter
    let targets = document.querySelectorAll(".filter");
    let activeTab = 0;
    let old = 0;
    let dur = 0.4;
    let animation;

    for (let i = 0; i < targets.length; i++) {
        targets[i].index = i;
        targets[i].addEventListener("click", moveBar);
    }

    // initial position on first === All 
    gsap.set(".filter-active", {
        x: targets[0].offsetLeft,
        width: targets[0].offsetWidth
    });

    function moveBar() {
        if (this.index != activeTab) {
            if (animation && animation.isActive()) {
                animation.progress(1);
            }
            animation = gsap.timeline({
                defaults: {
                    duration: 0.4
                }
            });
            old = activeTab;
            activeTab = this.index;
            animation.to(".filter-active", {
                x: targets[activeTab].offsetLeft,
                width: targets[activeTab].offsetWidth
            });

            animation.to(targets[old], {
                color: "#0d0d25",
                ease: "none"
            }, 0);
            animation.to(targets[activeTab], {
                color: "#fff",
                ease: "none"
            }, 0);

        }

    }
});

document.addEventListener("DOMContentLoaded", () => {
    // Data for each recipe
    const recipes = {
        pepperoniPizza: {
            name: "Pepperoni Pizza",
            prepTime: "10 minutes",
            cookTime: "10-12 minutes",
            ingredients: [
                "Pizza dough",
                "1/2 cup pizza sauce",
                "1 cup shredded mozzarella cheese",
                "20-25 slices of pepperoni",
                "1 tsp dried oregano",
                "1 tbsp olive oil",
            ],
            instructions: [
                "Preheat your oven to 500°F (260°C).",
                "Roll out the dough and transfer it to a baking tray or pizza stone.",
                "Spread the pizza sauce over the base, leaving a small border around the edges.",
                "Sprinkle mozzarella cheese evenly across the pizza.",
                "Arrange the pepperoni slices on top of the cheese.",
                "Sprinkle dried oregano and drizzle olive oil over the toppings.",
                "Bake for 10-12 minutes until the crust is crispy and the cheese is melted. Slice and enjoy!",
            ],
        },
        margheritaPizza: {
            name: "Margherita Pizza",
            prepTime: "15 minutes",
            cookTime: "12-15 minutes",
            ingredients: [
                "Pizza dough",
                "1/2 cup tomato sauce",
                "200g fresh mozzarella cheese, sliced",
                "Fresh basil leaves",
                "2 tbsp olive oil",
                "Salt to taste",
            ],
            instructions: [
                "Preheat your oven to 475°F (245°C).",
                "Roll out the pizza dough into a circle and place it on a pizza stone or baking sheet.",
                "Spread the tomato sauce evenly over the dough.",
                "Arrange the mozzarella slices on top.",
                "Drizzle olive oil over the pizza and sprinkle with salt.",
                "Bake for 12-15 minutes or until the crust is golden and the cheese is bubbling.",
                "Top with fresh basil leaves before serving.",
            ],
        },
        bbqChickenPizza: {
            name: "BBQ Chicken Pizza",
            prepTime: "20 minutes",
            cookTime: "15-20 minutes",
            ingredients: [
                "Pizza dough",
                "1/2 cup BBQ sauce",
                "1 cup cooked chicken breast, shredded",
                "1/2 cup red onion, sliced",
                "1 cup shredded mozzarella cheese",
                "Fresh cilantro (optional)",
            ],
            instructions: [
                "Preheat the oven to 450°F (230°C).",
                "Roll out the dough and spread BBQ sauce over the base.",
                "Top with shredded chicken and red onion slices.",
                "Sprinkle mozzarella cheese evenly on top.",
                "Bake for 15-20 minutes until the cheese is bubbly and the crust is golden.",
                "Garnish with fresh cilantro and serve hot.",
            ],
        },
    };

    // Function to render recipe details
    const renderRecipe = (recipeData) => {
        const recipeDetails = document.querySelector("#recidetails");
        recipeDetails.innerHTML = `
            <div class="recipe-details-container">
                <h2>${recipeData.name}</h2>
                <div class="recipe-meta">
                    <p><strong>Prep Time:</strong> ${recipeData.prepTime}</p>
                    <p><strong>Cook Time:</strong> ${recipeData.cookTime}</p>
                </div>
                <div class="recipe-ingredients">
                    <h3>Ingredients</h3>
                    <ul>
                        ${recipeData.ingredients.map((item) => `<li>${item}</li>`).join("")}
                    </ul>
                </div>
                <div class="recipe-instructions">
                    <h3>Instructions</h3>
                    <ol>
                        ${recipeData.instructions.map((step) => `<li>${step}</li>`).join("")}
                    </ol>
                </div>
            </div>
        `;
    };

    // Event listeners for recipe buttons
    document.querySelector("#recipe1Btn").addEventListener("click", () => {
        renderRecipe(recipes.pepperoniPizza);
    });

    document.querySelector("#recipe2Btn").addEventListener("click", () => {
        renderRecipe(recipes.margheritaPizza);
    });

    document.querySelector("#recipe3Btn").addEventListener("click", () => {
        renderRecipe(recipes.bbqChickenPizza);
    });
});
//Edit profile
