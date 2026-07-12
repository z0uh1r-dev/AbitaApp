const orvalConfig = {
  catalog: {
    input: "http://localhost:8000/docs.json",
    output: {
      target: "./src/api/abitaDashAPI.ts",
      client: "react-query",
      schemas: "./src/api/models",
      mode: "tags-split",
      prettier: true,
      allParamsOptional: false,
      baseUrl: "http://localhost:8000/api/v1",
    },
  },
};

export default orvalConfig;
