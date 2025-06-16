FROM oven/bun:1.2.5
WORKDIR /app
COPY . .
RUN bun install
CMD ["bun", "run", "start"]
