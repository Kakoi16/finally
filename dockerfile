# Gunakan Bun official image
FROM oven/bun:1.2.5

# Set direktori kerja di dalam container
WORKDIR /app

# Copy semua file dari project lokal ke dalam container
COPY . .

# Install dependencies
RUN bun install

# Jalankan aplikasi
CMD ["bun", "run", "start"]
