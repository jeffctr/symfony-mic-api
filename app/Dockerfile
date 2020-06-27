FROM node:12

# Create app directory
WORKDIR /usr/src/app

# Install packages
RUN apt-get update && apt-get install -y \
    ruby-dev \
    make \
    vim \
    git \
    wget

# Copy the json package
COPY code/package*.json ./

# Install npm packages
RUN npm install


EXPOSE 8080
CMD [ "node", "index.js" ]

