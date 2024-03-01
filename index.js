let food = [];
let totalAmount = 0;

$(document).ready(function () {
    if ($(document).width() <= 992) {
        $(".navbar-nav").removeClass("ml-auto");
        $(".navbar-nav").addClass("mr-auto");
    } else {
        $(".navbar-nav").removeClass("mr-auto");
        $(".navbar-nav").addClass("ml-auto");
    }

    // eto yung sa navbar kapag clinick
    $(".navbar a").on("click", function (event) {
        // Make sure this.hash has a value before overriding default behavior
        if (this.hash !== "") {
            // console.log(this);
            // console.log(this.hash);
            // Prevent default anchor click behavior
            event.preventDefault();
            // Store hash
            var hash = this.hash;
            // Using jQuery's animate() method to add smooth page scroll
            // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
            $("html, body").animate(
                {
                    scrollTop: $(hash).offset().top,
                },
                800,
                function () {
                    // Add hash (#) to URL when done scrolling (default click behavior)
                    window.location.hash = hash;
                }
            );
        } // End if
    });

    $(".homeBtn").click(function (event) {
        if (this.hash !== "") {
            event.preventDefault();
            let hash = this.hash;

            $("html, body").animate(
                {
                    scrollTop: $(hash).offset().top,
                },
                800,
                function () {
                    // Add hash (#) to URL when done scrolling (default click behavior)
                    window.location.hash = hash;
                }
            );
        }
    });

    // ends dito

    $(".product-box-layout4").click(function () {
        $(this)
            .toggleClass("productClicked")
            .parent()
            .siblings("div")
            .children()
            .removeClass("productClicked");
        if ($(this)[0].className.search("cafe productClicked") > -1) {
            $("#cafe").show().siblings("div").hide();

            $("html, body").animate(
                {
                    scrollTop: $("#cafe").offset().top,
                },
                800,
                function () {}
            );
        } else if ($(this)[0].className.search("cafe2 productClicked") > -1) {
            $("#cafe2").show().siblings("div").hide();

            $("html, body").animate(
                {
                    scrollTop: $("#cafe2").offset().top,
                },
                800,
                function () {}
            );
        } else if ($(this)[0].className.search("cafe3 productClicked") > -1) {
            $("#cafe3").show().siblings("div").hide();

            $("html, body").animate(
                {
                    scrollTop: $("#cafe3").offset().top,
                },
                800,
                function () {}
            );
        }
    });

    $(".menuBtn").click(function () {
        let quantity = $(this).siblings(".quantity");
        let foodNameClicked = quantity
            .parent()
            .siblings("div")
            .children()
            .first()
            .text()
            .trim();
        let singleFoodAmount = quantity.parent().siblings("div").children().last().text();
        let numericPart = singleFoodAmount.replace(/[^\d.]/g, '');
        if (!isNaN(numericPart)) {
            singleFoodAmount = parseFloat(numericPart);
        }
        let isVeg = quantity
            .parent()
            .siblings("div")
            .children()
            .first()
            .children()
            .first()
            .children()
            .hasClass("vegIcon");

        let count = Number(quantity.text());
        if ($(this)[0].className.search("plus") > -1) {
            count = count + 1;
            quantity.text(count);
            ToCart(foodNameClicked, count, isVeg, singleFoodAmount);
        } else if ($(this)[0].className.search("minus") > -1) {
            if (count <= 0) {
                quantity.text(0);
            } else {
                count = count - 1;
                quantity.text(count);
                ToCart(foodNameClicked, count, isVeg, singleFoodAmount);
            }
        }
    });

    function ToCart(foodNameClicked, foodQuantity, isVeg, singleFoodAmount) {
        let foodAlreadyThere = false;
        let foodPos;
        let node;
        if (isVeg) {
            node = '<img class="vegIcon" src="./images/veg.webp" alt="" />';
        } else {
            node = '<img class="nonVegIcon" src="./images/non-veg.webp" alt="" />';
        }
        for (var i = 0; i < food.length; i++) {
            if (food[i][0] === foodNameClicked) {
                foodAlreadyThere = true;
                foodPos = i;
                break;
            } else {
                foodAlreadyThere = false;
            }
        }

        if (foodAlreadyThere) {
            food.splice(foodPos, 1);
            food.push([foodNameClicked, foodQuantity, singleFoodAmount, node]);
        } else {
            food.push([foodNameClicked, foodQuantity, singleFoodAmount, node]);
        }

        // Remove Food items with quantity = 0
        for (var i = 0; i < food.length; i++) {
            if (food[i][1] === 0) {
                food.splice(i, 1);
            }
        }

        if (food.length !== 0) {
            $(".shoppingCart").addClass("shoppingCartWithItems");

            $(".cartContentDiv").empty();
            for (var i = 0; i < food.length; i++) {
                let cartTxt =
                    '<div class="row cartContentRow"><div class="col-10"><div style="display:flex;"><p>' +
                    food[i][0] +
                    '</p> <p class="text-muted-small">' +
                    food[i][3] +
                    '<p></div><i class="fa-solid fa-peso-sign"> ' +
                    food[i][2] +
                    '</i></p>  </div>  <div class="col-2"> <p class="text-muted-small" > <i class="fa-solid fa-peso-sign"></i> ' +
                    food[i][1] * food[i][2] +
                    '</p>  <span class="cartQuantity"> ' +
                    " <span> Qty : </span>" +
                    food[i][1] +
                    '</span> </div>  </div> <hr class="cartHr">';
                $(".cartContentDiv").append(cartTxt);
            }
        } else {
            $(".shoppingCart").removeClass("shoppingCartWithItems");

            $(".cartContentDiv").empty();
            $(".cartContentDiv").append(
                '<h1 class="text-muted">Your Cart is Empty</h1>'
            );
        }

        $(".shoppingCartAfter").text(food.length);
        if (food.length === 0) {
            totalAmount = 0;
        } else {
            totalAmount = totalAmount + singleFoodAmount;
        }
        $(".totalAmountDiv").empty();
        $(".totalAmountDiv").append(
            '<span class="totalAmountText">TOTAL AMOUNT : </span><br/>' +
            '<i class="fa-solid fa-peso-sign"></i> ' +
            totalAmount
        );
    }

    // Bind click event to the "Order Now" button
    $("#placeOrderBtn").click(function (event) {
        // Prevent default action of the button click
        event.preventDefault();

        // Call the placeOrder function
        placeOrder();
    });

    // Function to place the order
    function placeOrder() {
        var selectedItems = [];

        // Loop through each food item
        $(".row.foodItem").each(function (index) {
            var itemName = $(this).find(".foodItemName p:first-child").text().trim();
            var quantity = parseInt($(this).find(".quantity").text());
            var itemPrice = parseFloat($(this).find(".text-muted-small b").text());
            var totalAmount = quantity * itemPrice;

            if (quantity > 0) {
                // Push the selected item details to the selectedItems array
                selectedItems.push({
                    name: itemName,
                    quantity: quantity,
                    price: itemPrice,
                    total: totalAmount
                });
            }
        });

        // Collect other necessary information from the form
        var address = $("#address").val().trim();
        var note = $("#note").val().trim();

        // Check if the address is provided
        if (address === "") {
            alert("Please Enter Address");
            return;
        }

        // Send the order data along with other information to the server using AJAX
        $.ajax({
            type: "POST",
            url: "placeOrder.php", // Path to your PHP script
            data: { items: selectedItems, address: address, note: note },
            success: function (response) {
                // Handle success (e.g., show success message)
                alert(response); // Display a success message
            },
            error: function (xhr, status, error) {
                // Handle error (e.g., show error message)
                console.error("Error placing order:", error);
                alert("Error placing order. Please try again later.");
            }
        });
    }
});

