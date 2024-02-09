function [response] = recomendar(id_user)

javaaddpath("com.mysql.jdbc.jar")

[Y, R, movieList] = getData();

num_users=size(Y,2);
num_movies=size(Y,1);
num_features=10;

% Inicializa parametros (Theta, X)
X = randn(num_movies, num_features);
Theta = randn(num_users, num_features);

initial_parameters = [X(:); Theta(:)];

% Selecciona las opciones de fmincg
options = optimset('GradObj', 'on', 'MaxIter', 100);

% Ajusta regularizacion y ejecuta la optimizacion
lambda = 10;
theta = fmincg (@(t)(cofiCostFunc(t, Y, R, num_users, num_movies, num_features, lambda)), initial_parameters, options);

% Extrae X y Theta del vector resultante de la optimizacion
X = reshape(theta(1:num_movies*num_features), num_movies, num_features);
Theta = reshape(theta(num_movies*num_features+1:end), num_users, num_features);

p = X*Theta';


updateRecommendation(p, id_user);
response = 2;
