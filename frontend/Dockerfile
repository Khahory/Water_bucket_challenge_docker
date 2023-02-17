# what's base image?
FROM node:19.6.0-alpine3.17

# creating directory for the app
RUN mkdir -p /home/frontend

# setting working directory
WORKDIR /home/frontend

# copy app to the directory
COPY . .

# install dependencies
RUN #npm i -g nodemon
RUN npm install --silent

# expose port 3000
EXPOSE 3000

# when the container launches run the following command
CMD ["npm", "start"]
