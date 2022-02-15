import axios from "axios";

const websiteService = {
    async getArtworks({ page, perPage, productStatus, keyword, colName, dir }) {

        if (productStatus === 'Available') productStatus = 0;
        else productStatus = 1;

        const response = await axios.get(route('website.artworks'), {
            params: {
                page: page,
                perPage: perPage,
                productStatus: productStatus,
                keyword: keyword,
                columnName: (colName ? colName : 'id'),
                direction: dir
            }
        });

        return response;
    },

    async getArtwork(id) {
        const response = await axios.get(route('website.artwork.show', id));

        return response;
    },

    async getBlogs({ page, perPage, keyword, colName, dir, visits }) {
        const response =  await axios.get(route('website.blogs'), {
            params: {
                page: page,
                perPage: perPage,
                keyword: keyword,
                columnName: colName,
                direction: dir
            }
        });

        return response;
    },

    async getBlog(id) {
        const response = await axios.get(route('website.blogs.show', id));

        return response;
    },

    async getPhoto(id) {
        const response = await axios.get(route('website.photo.get', id));

        return response;
    },

    async createRequest(request) {
        const response = await axios.post(route('send.request'), request);

        return response;
    },

    async getAboutContent() {
        const response = await axios.get(route('website.content.about'));

        return response;
    },

    async createMessage(message) {
        const response = await axios.post(route('website.send.message'), message);

        return response;
    }
}

export default websiteService;
