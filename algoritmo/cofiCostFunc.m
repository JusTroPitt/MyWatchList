function [J, grad] = cofiCostFunc(params, Y, R, num_users, num_movies, ...
                                  num_features, lambda)
%COFICOSTFUNC Funcion de coste del filtrado colaborativo
%   [J, grad] = COFICOSTFUNC(params, Y, R, num_users, num_movies, ...
%   num_features, lambda) devuelve el coste y el gradiente
%   del problema de filtrado colaborativo

% Extrae las matrices U y W de params
X = reshape(params(1:num_movies*num_features), num_movies, num_features);
Theta = reshape(params(num_movies*num_features+1:end), ...
                num_users, num_features);

            
% Debes generar los siguientes valores correctamente
J = 0;
X_grad = zeros(size(X));
Theta_grad = zeros(size(Theta));


Theta_t = transpose(Theta);
xtheta = X*Theta_t; % características película*parámetros usuario
Err = xtheta - Y; % xtheta - puntuaciones dadas a la pelicula
Err2 = (Err.*R); % err*(si ha puntuado pelicula o no)

%Coste sin regularizar
J_noreg = (sum(Err2(:).^2)/2);

% Gradiente sin regularizar
X_grad = Err2*Theta;
Theta_grad = transpose(Err2)*X;

%Funcion de coste regularizada
Theta_m = Theta.^2;
X_m = X.^2;


J = J_noreg + (sum(Theta_m(:)))*lambda/2 + (sum(X_m(:)))*lambda/2;

%Gradiente regularizado
X_grad = (Err2*Theta) + lambda.*X;
Theta_grad = (transpose(Err2)*X) + lambda.*Theta;


% ====================== TU CODIGO AQUI ======================
% Instrucciones: Debes implementar en primer lugar la funcion de coste
%                (sin regularizacion) para filtrado colaborativo, y comprobar
%               que coincide con el coste indicado en la memoria. Despues de esto
%               debes implementar el gradiente y usar checkCostFunction para 
%               comprobar que es correcto. Finalmente, debes implementar 
%               regularizacion.
%
% Notas: X - num_movies  x num_features : matriz de caracteristicas de la pelicula
%        Theta - num_users  x num_features: matriz de parametros del usuario 
%        Y - num_movies x num_users: matriz de puntuaciones
%        R - num_movies x num_users: matriz en la que R(i, j) = 1 si la
%            i-esima pelicula ha sido puntuada por el j-esimo usuario
%
% Debes generar las siguientes variables correctamente:
%
%        X_grad - num_movies x num_features: matriz con las derivadas parciales 
%                 con respecto a cada elemento de X
%        Theta_grad - num_users x num_features: matriz con las derivadas parciales
%                 con respecto a cada elemento deTheta
%

% =============================================================

grad = [X_grad(:); Theta_grad(:)];

end
