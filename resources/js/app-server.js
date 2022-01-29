/* global context, dispatch */

import { createApp } from "./app";
import renderer from "vue-server-renderer/basic";

new Promise((resolve, reject) => {
    const { app, router, store } = createApp()

    router.push(context.url);
    router.onReady(() => {
        const matchedComponents = router.getMatchedComponents()

        if (!matchedComponents.length) { return reject({ code: 404 }) }

        context.state = store.state

        resolve(app)
    }, reject)
}).then((app) => {
    renderer(app, (err, html) => {
        if (err) {
            throw new Error(err);
        }

        dispatch(html);
    });
}).catch(err => {
    throw new Error(err);
});
