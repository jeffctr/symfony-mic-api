const Products = class {
    constructor(params) {
        this.url = 'http://shopping-api.docker/index.php/';
        this.method = params.method;
        this.formData = params.formData;

        document.getElementById('new-product').addEventListener('click', this.add)
    }

    list = () => {
        axios.get(`${this.url}products`)
            .then((response) => {
                const products = response.data
                if (!products) {
                    return 'There are not products available';
                }
                this.build(products);
            })
            .catch((error) => {
                console.log(error);
            });
    }

    add = (element) => {
        const form = element.target.closest('.form-control')
        if (!form) {
            return '';
        }

        // Get all input withing the form
        const inputs = form.querySelectorAll('input');

        let formData = {}
        inputs.forEach((input) => {
            formData[input.name] = input.value;
        })

        axios({
            method: 'post',
            url: `${this.url}product`,
            data: JSON.stringify(formData),
            header: {
                'Content-Type': 'application/json',
                'Access-Control-Allow-Origin': '*',
            }
        }).then(function (response) {
            console.log(response);
            list()
        }).catch(function (error) {
            console.log(error);
        });
    }

    /**
     * Build the HTML structure for the products with the data coming from the API
     * @param {Object} products
     */
    build = (products) => {
        const list = document.getElementById('product-list');
        products.forEach((product) => {
            const icon = this.createTag('span', {className: 'icon', innerText: 'in cart'});
            const isInTheCart = this.isProductInSession(product.id);

            const btnWrapper = this.createTag('div', {className: 'btn-wrapper'});
            btnWrapper.appendChild(this.createTag('img', {className: 'product-img', src: `/img/${product.image}.png` }));
            btnWrapper.appendChild(this.createTag('div', {className: 'layer'}));
            btnWrapper.appendChild(
                this.createTag('button', {
                    className: `btn ${isInTheCart ? '' : 'hide'}`,
                    id: 'remove',
                    onclick: this.addToCartRemoveFrom,
                    innerText: 'remove from cart'
                }));
            btnWrapper.appendChild(
                this.createTag('button', {
                    className: `btn ${isInTheCart ? 'hide' : ''}`,
                    id: 'addTo',
                    onclick: this.addToCartRemoveFrom,
                    innerText: 'add to cart'
                }));

            const description = this.createTag('div', {className: 'description'});
            description.appendChild(this.createTag('hr', {className: 'horizontal'}))
            description.appendChild(this.createTag('div', {className: 'name', innerText: product.name}));
            description.appendChild(this.createTag('div', {className: 'price', innerText: `$${product.price}`}));
            description.appendChild(this.buildRating(product.rating));

            const productTag = this.createTag('div', {
                className: `product ${isInTheCart ? 'active' : ''}`,
                id: product.id
            });
            productTag.appendChild(icon);
            productTag.appendChild(btnWrapper);
            productTag.appendChild(description);

            list.appendChild(productTag);
        });
    }

    /**
     * Build the HTML structure for the products rating
     *
     * @param {Integer} rate
     * @returns {Object}
     */
    buildRating = (rate) => {
        const rTop = this.createTag('div', {className: `star-rating-top ${rate}`, style: `width: calc(12 * ${rate}px);`});
        const rBottom = this.createTag('div', {className: 'star-rating-bottom'});
        for(let i=0; i<5; i++) {
            rTop.appendChild(this.createTag('span'));
            rBottom.appendChild(this.createTag('span'));
        }
        const rating = this.createTag('div', {className: 'star-rating'});
        rating.appendChild(rTop);
        rating.appendChild(rBottom);

        return rating;
    }

    /**
     * This function create a dynamic HTML element
     * @param {String} tag
     * @param {Object} options
     * @returns {Object}
     */
    createTag = (tag, options) => {
        return Object.assign(document.createElement(tag),options);
    }

    /**
     * Add product to the cart *
     * @param {Object} element
     */
    addToCartRemoveFrom = (element) => {
        const product = element.target.closest('.product');
        let tagId = '#remove';
        // Get data from the session or assign an array by default
        let session = sessionStorage.getItem('cart')
            ? sessionStorage.getItem('cart').split(',')
            : [];

        // Provide an specific logic to remove and add products to the cart
        if (element.target.id === 'remove') {
            tagId = '#addTo'
            product.classList.remove('active');
            // Remove product from the cart session
            session = session.filter(id => id !== product.id)
        } else {
            product.classList.add('active');
            // Add product into the cart session without mutation
            session = [...session, product.id]
            console.log('session', session)
        }

        sessionStorage.setItem('cart', session.join(','));
        element.target.classList.add('hide');
        const remove = product.querySelector(tagId);
        remove.classList.remove('hide');
    }

    /**
     *
     * @param {Integer} productId
     * @returns {Boolean}
     */
    isProductInSession = (productId) => {
        let session = sessionStorage.getItem('cart')
            ? sessionStorage.getItem('cart').split(',')
            : [];

        return session.some(id => parseInt(id, 10) === productId);
    }
}

document.onreadystatechange = () => {
    if (document.readyState === 'interactive') {
        new Products({
            'url': 'products',
            'method': 'get',
            'formData': ''
        }).list();

        console.log('Hwllo world');
    }
};
