// serve.js
import { serveStatic } from "hono/bun";

export default {
  port: 3000,
  fetch: serveStatic({ root: "./", rewriteRequestPath: () => "/index.html" }),
};
