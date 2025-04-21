const webUrl = $("meta[name='baseurl']").attr("content");
const csrf_token = $("meta[name='csrf_token']").attr("content");
const apiEndpoint = "/api/web/v1";



// Route start here
export const loginRoute = webUrl + "/" + apiEndpoint + "/login";             // api/web/v1/login-area

// Route end here
